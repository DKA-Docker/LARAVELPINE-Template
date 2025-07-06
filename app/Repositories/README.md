# Repository Pattern

- Fokus: Abstraksi akses data dari model/database
- Menyediakan interface antara controller dan model.
- Cocok saat kamu ingin ganti data source (contoh: dari Eloquent ke API/external DB).
- Biasanya method-nya: getAll(), findById($id), create(), update(), delete(), dll.
