<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Conversation;
use App\Models\Message;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use App\Events\MessageSent;

class MessageboxController extends Controller
{
    /**
     * Menampilkan daftar percakapan pengguna.
     */
    public function index()
    {
        $userId = Auth::id();

        // Ambil percakapan di mana pengguna adalah salah satu dari dua pihak
        $conversations = Conversation::where('user_id_1', $userId)
            ->orWhere('user_id_2', $userId)
            ->with(['user1', 'user2'])
            ->get();

        return view('message.index', compact('conversations'));
    }

    /**
     * Memulai percakapan baru atau mengambil percakapan yang ada.
     */
    public function start($userId)
    {
        // Logic untuk memulai percakapan baru
        $conversation = Conversation::firstOrCreate([
            'user_id_1' => auth()->id(),
            'user_id_2' => $userId,
        ]);

        // Redirect ke halaman detail percakapan
        return redirect()->route('message.show', $conversation);
    }

    /**
     * Fungsi untuk enkripsi pesan.
     */
    function encryptMessage($message, $key)
{
    $iv = substr($key, 0, 16); // Ambil 16 byte pertama sebagai IV
    return openssl_encrypt($message, 'AES-256-CBC', $key, 0, str_pad($iv, 16, "\0"));
}

function decryptMessage($encryptedMessage, $key)
{
    $iv = substr($key, 0, 16); // Ambil 16 byte pertama sebagai IV
    return openssl_decrypt($encryptedMessage, 'AES-256-CBC', $key, 0, str_pad($iv, 16, "\0"));
}

    /**
     * Menampilkan pesan dalam percakapan tertentu.
     */
    public function show(Conversation $conversation)
    {
        $userId = Auth::id();

        // Verifikasi bahwa pengguna adalah bagian dari percakapan
        if ($conversation->user_id_1 !== $userId && $conversation->user_id_2 !== $userId) {
            abort(403);
        }

        // Ambil semua pesan dalam percakapan ini, urutkan dari yang terlama ke terbaru
        $messages = $conversation->messages()
            ->orderBy('sent_at', 'asc')
            ->get()
            ->map(function ($message) {
                $message->content = $this->decryptMessage($message->content, env('ADMIN_ENCRYPTION_KEY'));
                return $message;
            });

        // Tandai pesan yang belum dibaca sebagai sudah dibaca
        $conversation->messages()
            ->where('sender_id', '!=', $userId)
            ->where('is_read', false)
            ->update(['is_read' => true]);

        return view('message.show', compact('conversation', 'messages'));
    }

    /**
     * Mengirim pesan baru dalam percakapan tertentu.
     */
    public function sendMessage(Request $request, Conversation $conversation)
{
    $request->validate([
        'content' => 'required|string|max:1000',
    ]);

    $userId = Auth::id();

    // Verifikasi bahwa pengguna adalah bagian dari percakapan
    if ($conversation->user_id_1 !== $userId && $conversation->user_id_2 !== $userId) {
        abort(403); // Forbidden
    }

    // Enkripsi pesan sebelum menyimpan ke database
    $encryptedContent = $this->encryptMessage($request->input('content'), env('ADMIN_ENCRYPTION_KEY'));

    // Simpan pesan yang terenkripsi
    $message = $conversation->messages()->create([
        'sender_id' => $userId,
        'content' => $encryptedContent,
        'is_read' => false,
        'sent_at' => now(),
    ]);

    // Menyiarkan pesan menggunakan event Pusher
    broadcast(new MessageSent($message)); // Broadcasting event

    // Redirect ke halaman percakapan setelah pesan terkirim
    return redirect()->route('message.show', $conversation);
}
}
