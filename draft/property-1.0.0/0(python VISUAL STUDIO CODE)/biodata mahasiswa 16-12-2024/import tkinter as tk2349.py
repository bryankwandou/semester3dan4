import tkinter as tk
from tkinter import ttk, messagebox
from tkcalendar import DateEntry  # Import DateEntry dari tkcalendar
from PIL import ImageTk, Image  # Untuk menampilkan logo

class DataEntryApp:
    def __init__(self, root):
        self.root = root
        self.root.title("Universitas Atma Jaya")

        # Frame untuk Halaman Utama/Selamat Datang
        self.splash_screen_frame = tk.Frame(self.root, height=200, bg="#ADD8E6")
        self.splash_screen_frame.pack_propagate(False)
        self.splash_screen_frame.pack(fill=tk.X)

        # Label untuk menampilkan logo universitas
        self.logo_image = self.load_logo('logo_universitas.png')

        splash_label = tk.Label(self.splash_screen_frame, image=self.logo_image)
        splash_label.image = self.logo_image  # Agar gambar tidak hilang
        splash_label.place(relx=.5,rely=.45,anchor=tk.CENTER)

        # Button untuk menuju ke halaman utama aplikasi
        confirm_button = tk.Button(splash_screen_frame,text='Mulai',fg='black',bg='#FFFF00',activebackground='#FFC080', activeforeground ='red',bd=5,width=10,height=2,relief='ridge',command=self.start_application)
        confirm_button.place(relx=.50,rely=.60, anchor=tk.CENTER )

    
    def load_logo(self,image_path):
       img=Image.open(image_path)
       photo=ImageTk.PhotoImage(img)
       return(photo)

    def validate_inputs(self):
        # Validasi input di sini
        for field_name, entry in self.entries.items():
            if isinstance(entry, ttk.Entry) or isinstance(entry, ttk.Combobox):
                value = entry.get()
                if not value:
                    messagebox.showerror("Input Error", f"{field_name} tidak boleh kosong!")
                    return False
            elif isinstance(entry, DateEntry):
                if not entry.get_date():
                    messagebox.showerror("Input Error", f"{field_name} tidak boleh kosong!")
                    return False
        return True

    def create_form(self):
        fields = [
            ("Stambuk", 0),
            ("Nama Mahasiswa", 1),
            ("Alamat Mahasiswa", 2),
            ("Nomor Telepon Mahasiswa", 3),
            ("Tempat Lahir", 4),
            ("Tanggal Lahir", 5),  # Ganti label ini
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

            if label_text == "Tanggal Lahir": 
                # Menggunakan DateEntry dari tkcalendar
                date_entry = DateEntry(self.frame, width=17)
                date_entry.grid(row=row_index, column=1)
                self.entries[label_text] = date_entry
            elif len(field) == 3:  
                combo = ttk.Combobox(self.frame, values=field[2])
                combo.grid(row=row_index, column=1)
                self.entries[label_text] = combo
            else:
                entry = ttk.Entry(self.frame)
                entry.grid(row=row_index, column=1)
                self.entries[label_text] = entry

    def show_summary(self):
        if not self.validate_inputs():
            return
        
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

    def submit_data(self, summary_window):
        # Simpan data ke dalam file
        with open("data_mahasiswa.txt", "w") as file:
            for field_name, entry in self.entries.items():
                value = entry.get() if isinstance(entry, (ttk.Entry, ttk.Combobox)) else entry.get_date()
                file.write(f"{field_name}: {value}\n")
        
        messagebox.showinfo("Informasi","Data telah disimpan!")
        
        summary_window.destroy()  # Tutup jendela ringkasan
        self.root.quit()          # Tutup aplikasi

if __name__ == "__main__":
    root = tk.Tk()
    app = DataEntryApp(root)
    root.mainloop()
