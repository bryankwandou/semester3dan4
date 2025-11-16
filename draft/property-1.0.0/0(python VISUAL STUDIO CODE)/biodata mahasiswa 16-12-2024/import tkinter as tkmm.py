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
            ("Pekerjaan Ayah", 14, ["Wiraswasta", "Pegawai Swasta", "Pegawai Negeri", "Dokter",
                                     "Pengacara", "Dosen", "Guru", "Tidak Bekerja"]),
            ("Nama Ibu", 15),
            ("Pekerjaan Ibu", 16, ["Ibu Rumah Tangga", "Wiraswasta", "Pegawai Swasta",
                                   "Pegawai Negeri", "Dokter", "Pengacara", "Dosen", "Guru"]),
            ("Alamat Orang Tua", 17),
            ("Nomor Telepon Orang Tua", 18),
            ("Nomor Handphone Ayah", 19),
            ("Nomor Handphone Ibu", 20),
            ("Pendidikan Terakhir Ayah", 21, ["SD", "SMP", "SMA", "S1", "S2", "S3"]),
            ("Pendidikan Terakhir Ibu", 22, ["SD", "SMP", "SMA", "S1", "S2", "S3"]),
            ("Fakultas", 23, ["Teknologi Informasi","Ekonomi","Hukum","Teknik"]),
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

    def show_summary(self):
        summary = ""
        for field_name, entry in self.entries.items():
            value = entry.get()
            summary += f"{field_name}: {value}\n"

        messagebox.showinfo("Hasil Entri Data Mahasiswa", summary)

if __name__ == "__main__":
    root = tk.Tk()
    app = DataEntryApp(root)
    root.mainloop()
