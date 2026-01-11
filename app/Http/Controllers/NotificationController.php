<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class NotificationController extends Controller
{
    /**
     * Menandai satu notifikasi sebagai sudah dibaca, lalu redirect ke link order.
     */
    public function markAsRead($id)
    {
        // Cari notifikasi milik user yang sedang login berdasarkan ID notifikasi
        $notification = auth()->user()->notifications()->findOrFail($id);
        
        // Tandai sebagai sudah dibaca (update kolom read_at di database)
        $notification->markAsRead();

        // Ambil link dari data notifikasi (yang kita set di NewOrderNotification.php)
        // Jika tidak ada link, redirect kembali ke halaman sebelumnya
        return redirect($notification->data['link'] ?? url()->previous());
    }

    /**
     * Menandai SEMUA notifikasi sebagai sudah dibaca.
     */
    public function markAllAsRead()
    {
        // Ambil semua notifikasi yang belum dibaca milik user login, lalu tandai baca
        auth()->user()->unreadNotifications->markAsRead();

        // Kembali ke halaman sebelumnya
        return back()->with('success', 'Semua notifikasi telah ditandai sebagai dibaca.');
    }
}