import tkinter as tk
from tkinter import ttk, messagebox

class DataEntryApp:
    def __init__(self, root):
        self.root = root
        self.root.title("Form Data Mahasiswa")

        # Frame untuk Form Data Mahasiswa
        self.frame = ttk.Frame(self.root, padding="10")
        self.frame.grid(row=0, column=0, sticky=(tk.W, tk.E))

        # Field Data
        self.create_form()

        # Tombol Tampilkan Hasil Entri
        self.submit_button = ttk.Button(self.frame, text="Tampilkan Hasil Entri", command=self.show_summary)
        self.submit_button.grid(row=27, column=0, columnspan=2)

    def validate_date(self, date_str):
        try:
            day, month, year = map(int, date_str.split('/'))
            if 1 <= day <= 31 and 1 <= month <= 12 and year > 1900:
                return True
            else:
                return False
        except ValueError:
            return False

    def validate_phone(self, phone_str):
        return phone_str.isdigit() and 10 <= len(phone_str) <= 12

    def on_invalid(self):
        messagebox.showerror("Input Error", "Input tidak valid! Silakan periksa kembali.")

    def create_form(self):
        fields = [
            ("Stambuk", 0),
            ("Nama Mahasiswa", 1),
            ("Alamat Mahasiswa", 2),
            ("Nomor Telepon Mahasiswa", 3),
            ("Tempat Lahir", 4),
            ("Tanggal Lahir (DD/MM/YYYY)", 5),
            ("Agama", 6, ["Islam", "Katolik", "Kristen", "Buddha", "Hindu"]),
            ("Jenis Kelamin", 7, ["Pria", "Wanita"]),
            ("Status Kewarganegaraan", 8, ["WNI", "WNA"]),
            ("Golongan Darah", 9, ["A", "B", "AB", "O"]),
            ("Asal SMA", 10),
            ("Jurusan SMA", 11, ["IPA", "IPS"]),
            ("Nilai NEM", 12),
            ("Nama Ayah", 13),
            ("Pekerjaan Ayah", 14, ["Wiraswasta", "Pegawai Swasta", "Pegawai Negeri",
                                     "Dokter", "Pengacara", "Dosen", "Guru",
                                     "Tidak Bekerja"]),
            ("Nama Ibu", 15),
            ("Pekerjaan Ibu", 16, ["Ibu Rumah Tangga", "Wiraswasta",
                                   "Pegawai Swasta", "Pegawai Negeri",
                                   "Dokter", "Pengacara", "Dosen", "Guru"]),
            ("Alamat Orang Tua", 17),
            ("Nomor Telepon Orang Tua", 18),
            ("Nomor Handphone Ayah", 19),
            ("Nomor Handphone Ibu", 20),
            ("Pendidikan Terakhir Ayah", 21,
             ["SD", "SMP", "SMA", "S1", "S2", "S3"]),
            ("Pendidikan Terakhir Ibu", 22,
             ["SD", "SMP", "SMA", "S1", "S2", "S3"]),
            ("Fakultas", 23,
             ["Teknologi Informasi","Ekonomi","Hukum","Teknik"]),
            ("Jurusan Universitas", 24,
             ["Teknik Informatika","Sistem Informasi","Akuntansi","Manajemen",
              "Ilmu Hukum","Teknik Sipil","Teknik Mesin","Teknik Elektro","Psikologi"]),
            ("Nama Penasehat Akademik (Dosen)", 25)
        ]

        self.entries = {}
        
        for field in fields:
            label_text = field[0]
            row_index = field[1]
            
            label = ttk.Label(self.frame, text=label_text)
            label.grid(row=row_index, column=0, sticky=tk.W)

            if len(field) == 3:  # Jika ada pilihan dropdown
                combo = ttk.Combobox(self.frame, values=field[2])
                combo.grid(row=row_index, column=1)
                self.entries[label_text] = combo
            else:
                entry = ttk.Entry(self.frame)
                entry.grid(row=row_index, column=1)
                self.entries[label_text] = entry

                # Validasi untuk nomor telepon dan tanggal lahir
                if label_text == "Tanggal Lahir (DD/MM/YYYY)":
                    entry.configure(validate="focusout")
                    vcmd_date = (self.frame.register(self.validate_date), '%P')
                    entry.configure(validatecommand=vcmd_date)
                    entry.bind("<FocusOut>", lambda e: self.on_invalid() if not self.validate_date(entry.get()) else None)

                elif label_text in ["Nomor Telepon Mahasiswa",
                                     "Nomor Telepon Orang Tua",
                                     "Nomor Handphone Ayah",
                                     "Nomor Handphone Ibu"]:
                    entry.configure(validate="focusout")
                    vcmd_phone = (self.frame.register(self.validate_phone), '%P')
                    entry.configure(validatecommand=vcmd_phone)
                    entry.bind("<FocusOut>", lambda e: self.on_invalid() if not self.validate_phone(entry.get()) else None)

    def show_summary(self):
        summary = ""
        for field_name, entry in self.entries.items():
            value = entry.get()
            summary += f"{field_name}: {value}\n"

        # Tampilkan ringkasan
        messagebox.showinfo("Hasil Entri Data Mahasiswa", summary)

        # Simpan data ke dalam file
        with open("data_mahasiswa.txt", "w") as file:
            file.write(summary)

if __name__ == "__main__":
    root = tk.Tk()
    app = DataEntryApp(root)
    root.mainloop()
