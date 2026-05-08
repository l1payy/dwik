Build a full-stack web application "E-Surat BPBD Kota Binjai" 
using Laravel (backend) + Blade/Livewire or Vue.js (frontend) 
+ MySQL (database) + Tailwind CSS (styling).

=== DESIGN REFERENCE ===
Orange (#E85D04) and white theme. Top navbar only (no sidebar).
Clean government dashboard style.

=== TECH STACK ===
- Backend: Laravel 11, PHP 8.2
- Frontend: Blade + Alpine.js + Tailwind CSS
- Database: MySQL
- Auth: Laravel Breeze (role-based)
- PDF Export: barryvdh/laravel-dompdf
- Word Export: phpoffice/phpword
- Real-time: Laravel Echo + Pusher (notifications)

=== DATABASE TABLES ===
users: id, nama, nip, jabatan, email, password, role 
(enum: sekretaris, pimpinan, staff), status, timestamps

surat_masuk: id, no_surat, no_agenda, tanggal_surat, 
tanggal_masuk, pengirim, instansi_pengirim, perihal, 
sifat (enum: biasa, penting, rahasia), prioritas 
(enum: normal, urgent), status (enum: diterima, 
terdisposisi, selesai), file_lampiran, catatan, 
created_by, timestamps

surat_keluar: id, no_surat, tanggal_surat, tujuan, 
instansi_tujuan, perihal, sifat, prioritas, isi_surat, 
status (enum: draft, review, terkirim), file_surat, 
penanda_tangan, created_by, timestamps

disposisi: id, no_disposisi, surat_masuk_id, dari_user_id, 
kepada_user_id, instruksi, catatan, prioritas, 
status (enum: menunggu, diproses, selesai), 
batas_waktu, timestamps

notifikasi: id, user_id, judul, pesan, tipe, 
is_read, related_id, related_type, timestamps

=== PAGES & FEATURES ===

1. AUTH
- Login page with role detection
- Role: Sekretaris (full access), Pimpinan (view + approve/respond)

2. DASHBOARD (all roles)
- Stat cards: Total Surat Masuk, Total Surat Keluar, 
  Disposisi Selesai, Pending
- Quick action buttons: Tambah Surat Masuk, 
  Tambah Surat Keluar, Buat Disposisi
- Bar chart monthly activity (Masuk vs Keluar)
- Recent activity feed

3. SURAT MASUK (full CRUD - Sekretaris only edit/delete)
- Table: No Surat, Tanggal, Pengirim, Perihal, 
  Sifat badge, Prioritas badge, Status badge, Aksi
- Filter: by Sifat, Prioritas, Status, Tanggal range
- Search by No Surat or Perihal
- Action buttons per row: Disposisi, Detail (eye), 
  Edit (pencil), Delete (trash) — icon buttons
- Export: PDF, Word, JPEG per row and bulk
- Modal: Tambah/Edit Surat Masuk form

4. SURAT KELUAR (full CRUD - Sekretaris only)
- Table: No Surat, Tanggal, Tujuan, Perihal, 
  Sifat, Status, Aksi
- Status flow: Draft → Review → Terkirim
- Pimpinan can approve (Review → Terkirim)
- Modal form: Nomor Surat (auto), Tanggal, Tujuan, 
  Perihal, Sifat dropdown, Prioritas toggle 
  (Rendah/Sedang/Tinggi), Upload file PDF, 
  buttons: Simpan Draft / Kirim untuk Review

5. DISPOSISI
- List table with tracking status
- Detail page: Informasi Surat card + 
  Tracking Disposisi vertical stepper 
  (Sekretaris → Kepala BPBD → Staff/Pelaksana)
- Riwayat Disposisi table: Dari, Ke, 
  Catatan/Instruksi, Tanggal
- Pimpinan can add disposition note and 
  forward to next person
- Status badges: Selesai (green), 
  Sedang Berjalan (orange), Menunggu (gray)

6. ARSIP
- Archived letters (completed dispositions)
- Search and filter by year, month, type

7. LAPORAN
- Monthly/quarterly report generation
- Charts and statistics
- Export to PDF/Word

8. NOTIFICATION PANEL (real-time)
- Slide-in panel from right side
- Categories: Notifikasi Terkini, Pesan Sistem, 
  Update Status, Log Aktivitas, Pengingat
- Unread count badge on bell icon
- Mark all as read button
- Real-time push via Pusher

=== UI COMPONENTS ===
- Top navbar: Logo left, nav tabs center 
  (with unread badge on Surat Masuk), 
  search + bell + avatar right
- Status badges as colored pills
- Orange primary buttons, outline secondary
- White cards with subtle shadow
- Modal forms with clean inputs
- Responsive table with hover states
- Toast notifications for actions

=== ROLE PERMISSIONS ===
Sekretaris: full CRUD all modules + export + manage users
Pimpinan: view all + approve surat keluar + 
          add disposisi note + mark disposisi selesai

=== AUTO FEATURES ===
- Auto-generate nomor surat format: 
  BPBD/YYYY/MASUK/NNN or BPBD-BJI/YYYY/SK/NNN
- Auto-timestamp on status changes
- Auto-notification on: new surat masuk, 
  disposisi received, deadline reminder (H-1)

Generate complete project structure with:
- All migrations
- Models with relationships
- Controllers (resource)
- Blade views matching the orange/white design
- Routes (web.php)
- Middleware for role checking
- Seeders for dummy data