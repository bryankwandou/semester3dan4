import tkinter as tk
from tkinter import ttk, messagebox
from tkcalendar import DateEntry
from PIL import Image, ImageTk  # Untuk menampilkan logo

class DataEntryApp:
    def __init__(self, root):
        self.root = root
        self.root.title("Universitas Atma Jaya")

        self.current_frame = None

        # Menampilkan halaman selamat datang
        self.show_welcome_page()

    def show_welcome_page(self):
        if self.current_frame is not None:
            self.current_frame.destroy()

        self.current_frame = tk.Frame(self.root, bg="#ADD8E6")
        self.current_frame.pack(fill=tk.BOTH, expand=True)

        # Menampilkan logo universitas
        logo_image = Image.open('logo_universitas.png')  # Ganti dengan path logo Anda
        logo_image = logo_image.resize((200, 100), Image.ANTIALIAS)
        self.logo = ImageTk.PhotoImage(logo_image)

        logo_label = tk.Label(self.current_frame, image=self.logo, bg="#ADD8E6")
        logo_label.pack(pady=20)

        welcome_label = tk.Label(self.current_frame, text="Selamat Datang di Universitas Atma Jaya", bg="#ADD8E6", font=("Arial", 16))
        welcome_label.pack(pady=10)

        start_button = ttk.Button(self.current_frame, text="Mulai", command=self.show_entry_page)
        start_button.pack(pady=20)

    def show_entry_page(self):
        if self.current_frame is not None:
            self.current_frame.destroy()

        self.current_frame = tk.Frame(self.root)
        self.current_frame.pack(fill=tk.BOTH, expand=True)

        # Membuat form entri data
        fields = [
            ("Stambuk", 0),
            ("Nama Mahasiswa", 1),
            ("Alamat Mahasiswa", 2),
            ("Nomor Telepon Mahasiswa", 3),
            ("Tanggal Lahir", 4),
            ("Agama", 5, ["Islam", "Katolik", "Kristen", "Buddha", "Hindu"]),
            ("Jenis Kelamin", 6, ["Pria", "Wanita"]),
            ("Status Kewarganegaraan", 7, ["WNI", "WNA"]),
            ("Golongan Darah", 8, ["A", "B", "AB", "O"]),
            ("Asal SMA/SMK", 9),
            ("Jurusan SMA/SMK", 10, ["IPA", "IPS"]),
            ("Nilai NEM", 11),
            ("Nama Ayah", 12),
            ("Pekerjaan Ayah", 13, ["Wiraswasta", "Pegawai Swasta", "Pegawai Negeri",
                                     "Dokter", "Pengacara", "Dosen", "Guru",
                                     "Tidak Bekerja"]),
            ("Nama Ibu", 14),
            ("Pekerjaan Ibu", 15, ["Ibu Rumah Tangga", "Wiraswasta",
                                   "Pegawai Swasta", "Pegawai Negeri",
                                   "Dokter", "Pengacara", "Dosen", "Guru"]),
            ("Alamat Orang Tua", 16),
            ("Nomor Telepon Orang Tua", 17),
            ("Nomor Handphone Ayah", 18),
            ("Nomor Handphone Ibu", 19),
            ("Pendidikan Terakhir Ayah", 20,
             ["SD", "SMP", "SMA", "S1", "S2", "S3"]),
            ("Pendidikan Terakhir Ibu", 21,
             ["SD", "SMP", "SMA", "S1", "S2", "S3"]),
            ("Fakultas", 22,
             ["Teknologi Informasi","Ekonomi","Hukum","Teknik"]),
            ("Jurusan Universitas", 23,
             ["Teknik Informatika","Sistem Informasi","Akuntansi","Manajemen",
              "Ilmu Hukum","Teknik Sipil","Teknik Mesin","Teknik Elektro","Psikologi"]),
            ("Nama Penasehat Akademik (Dosen)", 24)
        ]

        self.entries = {}

        for field in fields:
            label_text = field[0]
            row_index = field[1]

            label = ttk.Label(self.current_frame, text=label_text)
            label.grid(row=row_index, column=0, sticky=tk.W)

            if len(field) == 3:  
                combo = ttk.Combobox(self.current_frame, values=field[2])
                combo.grid(row=row_index, column=1)
                self.entries[label_text] = combo
            else:
                entry = ttk.Entry(self.current_frame)
                entry.grid(row=row_index, column=1)
                self.entries[label_text] = entry

                # Khusus untuk tanggal lahir
                if label_text == "Tanggal Lahir":
                    date_entry = DateEntry(self.current_frame)
                    date_entry.grid(row=row_index, column=1)
                    self.entries[label_text] = date_entry

        submit_button = ttk.Button(self.current_frame, text="Tampilkan Data",
                                    command=self.show_summary_page)
        submit_button.grid(row=len(fields), columnspan=2)

    def show_summary_page(self):
        if self.validate_inputs():
            summary_window = tk.Toplevel(self.root)
            summary_window.title("Ringkasan Data")

            summary_text = ""
            for field_name, entry in self.entries.items():
                value = entry.get() if isinstance(entry, (ttk.Entry, ttk.Combobox)) else entry.get_date()
                summary_text += f"{field_name}: {value}\n"

            summary_label = ttk.Label(summary_window, text=summary_text)
            summary_label.pack(pady=10)

            submit_button = ttk.Button(summary_window, text="Submit dan Tutup Aplikasi",
                                        command=lambda: self.submit_data(summary_window))
            submit_button.pack(pady=10)

    def validate_inputs(self):
        for field_name, entry in self.entries.items():
            if isinstance(entry, (ttk.Entry, ttk.Combobox)):
                value = entry.get()
                if not value:
                    messagebox.showerror("Input Error",
                                         f"{field_name} tidak boleh kosong!")
                    return False
        return True

    def submit_data(self, summary_window):
        with open("data_mahasiswa.txt", "w") as file:
            for field_name, entry in self.entries.items():
                value = entry.get() if isinstance(entry, (ttk.Entry, ttk.Combobox)) else entry.get_date()
                file.write(f"{field_name}: {value}\n")

        messagebox.showinfo("Informasi","Data telah disimpan!")
        
        summary_window.destroy()  
        self.root.quit()         

if __name__ == "__main__":
    root = tk.Tk()
    app = DataEntryApp(root)
    root.mainloop()
