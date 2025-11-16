#import gui
import tkinter as tk
from tkinter import ttk, messagebox
from PIL import Image, ImageTk
from tkcalendar import DateEntry 

from tkinter import PhotoImage








#kelas untuk formulir
class FormApp:
    def __init__(self, root):
        self.root = root
        self.root.title("Formulir Biodata Mahasiswa Universitas Atma Jaya Makassar")
        self.root.geometry("800x600")
        

        logo_image = PhotoImage(file="C:/Users/arche/Downloads/uajm (1).png")  # Ganti dengan path gambar Anda
        root.iconphoto(True, logo_image)  # Mengatur gambar sebagai ikon






        #warna
        self.bg_color = "#003366"  # biru atmajaya
        self.border_color = "#FFD700"  # kuning atmajaya
        




        self.form_data = {
            "stambuk": "",
            "nama_lengkap": "",
            "alamat": "",
            "nomor_telepon": "",
            "tempat_lahir": "",
            "tanggal_lahir": "",
            "agama": "",
            "jenis_kelamin": "",
            "kewarganegaraan": "",
            "golongan_darah": "",
            "rhesus": "",
            "asal_sma": "",
            "alamat_sma": "",
            "nilai_nem": "",
            "jurusan_sma": "",
            "nama_ayah": "",
            "pekerjaan_ayah": "",
            "pendidikan_ayah": "",
            "nama_ibu": "",
            "pekerjaan_ibu": "",
            "pendidikan_ibu": "",
            "fakultas": "",
            "jurusan": "",
            "nama_penasehat": ""
        }









        #array untuk menunjukkan halaman formulir
        self.pages = []
        self.current_page = 0








        # deklarasi halaman
        self.create_welcome_page()
        self.create_personal_info_page()
        self.create_highschool_info_page()
        self.create_father_info_page()
        self.create_mother_info_page()
        self.create_faculty_info_page()
        self.create_summary_page()









        # tombol navigasi halaman
        self.navigation_frame = tk.Frame(self.root, bg=self.border_color)
        self.navigation_frame.pack(side=tk.BOTTOM, fill=tk.X)
        
        self.page_label = tk.Label(self.navigation_frame, bg=self.border_color, font=("Times New Roman", 12))
        self.page_label.pack(side=tk.LEFT, padx=10)
        
        self.prev_button = tk.Button(self.navigation_frame, text="Sebelumnya", command=self.previous_page)
        self.prev_button.pack(side=tk.LEFT, padx=10)
        
        self.next_button = tk.Button(self.navigation_frame, text="Berikutnya", command=self.next_page)
        self.next_button.pack(side=tk.RIGHT, padx=10)
        




        # Tampilkan halaman pertama
        self.show_page(0)
    









    #halaman selamat datang
    def create_welcome_page(self):
        page = tk.Frame(self.root, bg=self.bg_color)
    



        try:
            # Mencoba memuat gambar logo
            logo = Image.open("C:/Users/arche/Downloads/uajm (1).png")  # Ganti dengan path gambar logo kamu
            logo = logo.resize((200, 200))  # Ubah ukuran gambar sesuai keinginan
            logo_photo = ImageTk.PhotoImage(logo)

            # Menambahkan logo di atas teks
            logo_label = tk.Label(page, image=logo_photo, bg=self.bg_color)
            logo_label.image = logo_photo  # Menyimpan referensi gambar agar tidak hilang
            logo_label.pack(pady=20)  # Menambahkan jarak atas antara logo dan teks

        except (FileNotFoundError, IOError) as e:
            # Jika gambar tidak ditemukan atau ada kesalahan dalam memuat gambar
            messagebox.showerror("Error", "Gambar logo tidak ditemukan atau tidak valid.\n" + str(e))
            # Menampilkan pesan kesalahan, lalu menambahkan teks tanpa logo
            logo_label = tk.Label(page, text="Gambar logo tidak tersedia", fg="#FFD700", bg=self.bg_color)
            logo_label.pack(pady=20)











        # Menambahkan teks selamat datang
        tk.Label(
            page,
            text="Selamat Datang di Universitas Atma Jaya Makassar",
            font=("Times New Roman",24, "bold"),
            fg="#FFFFFF", # Teks putih
            bg=self.bg_color,
        ).pack(expand=True)
        self.pages.append(page)
    













    #biodata mahasiswa
    def create_personal_info_page(self):
        page = tk.Frame(self.root, bg=self.bg_color)
        global STANBUK, NAMA_MAHASISWA, NOMOR_TELEPON, TEMPAT_LAHIR, TANGGAL_LAHIR, AGAMA, JENIS_KELAMIN, STATUS_KEWARGANEGARAAN, GOLONGAN_DARAH, ASAL_SMA, JURUSAN_SMA, NILAI_NEM
        
        tk.Label(page, text="Informasi Pribadi Mahasiswa", font=("Times New Roman", 16, "bold"),fg="#FFFFFF", bg=self.bg_color).pack()
        
    
        # List field untuk input teks


 
        stanbuk_label = ttk.Label( text="STANBUK MAHASISWA", )
        stanbuk_label.pack(pady=5, fill="x", expand=True)
        STANBUK = tk.StringVar()
        stanbuk_entry = ttk.Entry(textvariable=STANBUK)
        stanbuk_entry.pack(pady=5, fill="x", expand=True)

        nama_mahasiswa_label = ttk.Label( text="NAMA MAHASISWA")
        nama_mahasiswa_label.pack(pady=5, fill="x", expand=True)
        NAMA_MAHASISWA = tk.StringVar()
        nama_mahasiswa_entry = ttk.Entry( textvariable=NAMA_MAHASISWA)
        nama_mahasiswa_entry.pack(pady=5, fill="x", expand=True)

        nomor_telepon_label = ttk.Label(text="NOMOR TELEPON")
        nomor_telepon_label.pack(pady=5, fill="x", expand=True)
        NOMOR_TELEPON = tk.StringVar()
        nomor_telepon_entry = ttk.Entry( textvariable=NOMOR_TELEPON)
        nomor_telepon_entry.pack(pady=10, fill="x", expand=True)

        tempat_lahir_label = ttk.Label( text="TEMPAT LAHIR")
        tempat_lahir_label.pack(pady=5, fill="x", expand=True)
        TEMPAT_LAHIR = tk.StringVar()
        tempat_lahir_entry = ttk.Entry( textvariable=TEMPAT_LAHIR)
        tempat_lahir_entry.pack(pady=5, fill="x", expand=True)

        tanggal_lahir_label = ttk.Label( text="TANGGAL LAHIR")
        tanggal_lahir_label.pack(pady=5, fill="x", expand=True)
        TANGGAL_LAHIR = tk.StringVar()
        tanggal_lahir_entry = DateEntry( textvariable=TANGGAL_LAHIR)
        tanggal_lahir_entry.pack(pady=5, fill="x", expand=True)

        agama_label = ttk.Label( text="AGAMA")
        agama_label.pack(pady=5, fill="x", expand=True)
        AGAMA = tk.StringVar()
        agama_combobox = ttk.Combobox( values=["Islam", "Katolik", "Kristen", "Buddha", "Hindu"], state="readonly", textvariable=AGAMA)
        agama_combobox.pack(pady=5, fill="x", expand=True)

        jenis_kelamin_label = ttk.Label(text="JENIS KELAMIN")
        jenis_kelamin_label.pack(pady=5, anchor="w")
        JENIS_KELAMIN = tk.StringVar()
        tk.Radiobutton( text="Pria", variable=JENIS_KELAMIN, value="Pria").pack(pady=2, anchor="w")
        tk.Radiobutton( text="Wanita", variable=JENIS_KELAMIN, value="Wanita").pack(pady=2, anchor="w")

        kewarganegaraan_label = ttk.Label(text="STATUS KEWARGANEGARAAN")
        kewarganegaraan_label.pack(pady=5, anchor="w")
        STATUS_KEWARGANEGARAAN = tk.StringVar()
        tk.Radiobutton(text="WNI", variable=STATUS_KEWARGANEGARAAN, value="WNI").pack(pady=2, anchor="w")
        tk.Radiobutton( text="WNA", variable=STATUS_KEWARGANEGARAAN, value="WNA").pack(pady=2, anchor="w")

        golongan_darah_label = ttk.Label(text="GOLONGAN DARAH")
        golongan_darah_label.pack(pady=5, anchor="w")
        GOLONGAN_DARAH = tk.StringVar()
        tk.Radiobutton(text="A", variable=GOLONGAN_DARAH, value="A").pack(pady=2, anchor="w")
        tk.Radiobutton(text="B", variable=GOLONGAN_DARAH, value="B").pack(pady=2, anchor="w")
        tk.Radiobutton(text="AB", variable=GOLONGAN_DARAH, value="AB").pack(pady=2, anchor="w")
        tk.Radiobutton(text="O", variable=GOLONGAN_DARAH, value="O").pack(pady=2, anchor="w")
    # Simpan halaman
        self.pages.append(page)
        page.pack(fill="both", expand=True)








    #informasi sma
    def create_highschool_info_page(self):
        page = tk.Frame(self.root, bg=self.bg_color)
        tk.Label(page, text="Informasi SMA/SMK", font=("Times New Roman", 16, "bold"), 
             fg="#FFFFFF", bg=self.bg_color).pack()

    # Variabel untuk input field
        ASAL_SEKOLAH=tk.StringVar
        self.entry_asal_sekolah = tk.Entry(page, textvariable=ASAL_SEKOLAH)
        self.entry_alamat_sekolah = tk.Entry(page)
        self.entry_nilai_nem = tk.Entry(page)
    
    # Field dan entry
        tk.Label(page, text="Asal SMA/SMK", fg="#FFFFFF", bg=self.bg_color).pack(anchor="w", padx=20)
        self.entry_asal_sekolah.pack(fill="x", padx=20, pady=5)
    
        tk.Label(page, text="Alamat SMA/SMK", fg="#FFFFFF", bg=self.bg_color).pack(anchor="w", padx=20)
        self.entry_alamat_sekolah.pack(fill="x", padx=20, pady=5)
    
        tk.Label(page, text="Nilai NEM", fg="#FFFFFF", bg=self.bg_color).pack(anchor="w", padx=20)
        self.entry_nilai_nem.pack(fill="x", padx=20, pady=5)

        
        self.jurusan_var = tk.StringVar()
        self.jurusan_var.set("IPA")
        tk.Label(page, text="Jurusan SMA", fg="#FFFFFF", bg=self.bg_color).pack(anchor="w", padx=20)

        # Frame untuk Radio Buttons secara horizontal
        jurusan_frame = tk.Frame(page, bg=self.bg_color)
        jurusan_frame.pack(anchor="w", padx=20, pady=5)

        # Radio buttons dalam susunan horizontal
        tk.Radiobutton(jurusan_frame, text="IPA", variable=self.jurusan_var, value="IPA", fg="#FFD700", bg=self.bg_color, command=self.show_other_field).pack(side="left", padx=10)
        tk.Radiobutton(jurusan_frame, text="IPS", variable=self.jurusan_var, value="IPS", fg="#FFD700", bg=self.bg_color, command=self.show_other_field).pack(side="left", padx=10)
        tk.Radiobutton(jurusan_frame, text="Yang Lain", variable=self.jurusan_var, value="Yang Lain", fg="#FFD700", bg=self.bg_color, command=self.show_other_field).pack(side="left", padx=10)

        # Field lain untuk jurusan "Yang Lain"
        self.other_field = tk.Entry(page, bg="white")

        self.pages.append(page)

    def validate_input(self):
        """Memeriksa apakah semua field wajib sudah diisi"""
        for key, entry in self.entries.items():
            if isinstance(entry, tk.Entry) and entry.get().strip() == "":
                messagebox.showwarning("Peringatan", f"Silakan isi {key}")
                return  # Menghentikan proses jika ada input kosong

            if isinstance(entry, ttk.Combobox) and entry.get().strip() == "":
                messagebox.showwarning("Peringatan", f"Silakan pilih {key}")
                return  # Menghentikan proses jika ada input kosong

            if isinstance(entry, DateEntry) and entry.get() == "":
                messagebox.showwarning("Peringatan", f"Silakan pilih {key}")
                return  # Menghentikan proses jika ada input kosong

        self.save_input()  # Jika semua data terisi, simpan dan lanjutkan
        messagebox.showinfo("Info", "Data berhasil disimpan!")
        # Anda dapat melanjutkan untuk berpindah halaman atau tindakan lain setelah berhasil menyimpan data

    def save_input(self):
        """Menyimpan inputan ke form_data"""
        for key, entry in self.entries.items():
            if isinstance(entry, tk.Entry):
                self.form_data[key] = entry.get()
            elif isinstance(entry, ttk.Combobox):
                self.form_data[key] = entry.get()
            elif isinstance(entry, DateEntry):
                self.form_data[key] = entry.get()

        print(self.form_data)  # Debug: menampilkan data yang disimpan




    def show_other_field(self):
        # Menyembunyikan atau menampilkan field lainnya tergantung pilihan jurusan
        if self.jurusan_var.get() == "Yang Lain":
            self.other_field.pack(anchor="w", padx=60, pady=10)  # Menampilkan field
        else:
            self.other_field.pack_forget()  # Menyembunyikan field


    #informasi ayah
    def create_father_info_page(self):
        page = tk.Frame(self.root, bg=self.bg_color)
        tk.Label(page, text="Informasi Ayah", font=("Times New Roman", 16, "bold"),fg="#FFFFFF", bg=self.bg_color).pack()
        
        fields = [
            "Nama Lengkap Ayah", "Nama Panggilan Ayah", "Alamat Tempat Tinggal Ayah",
            "Nomor Telepon Ayah"
        ]
        for field in fields:
            tk.Label(page, text=field,fg="#FFFFFF", bg=self.bg_color).pack(anchor="w", padx=20)
            tk.Entry(page).pack(fill="x", padx=20, pady=5)
        
        tk.Label(page, text="Pendidikan Terakhir Ayah",fg="#FFFFFF", bg=self.bg_color).pack(anchor="w", padx=20)
        ttk.Combobox(page, values=["Tidak Bersekolah","SD", "SMP", "SMA/Sederajat","D1","D2", "D3/S1", "S2", "S3"]).pack(fill="x", padx=20, pady=5)
        
        tk.Label(page, text="Pekerjaan Ayah", fg="#FFFFFF", bg=self.bg_color).pack(anchor="w", padx=20)
        ttk.Combobox(page, values=["Wiraswasta", "Pegawai Swasta", "Pegawai Negeri", "Dokter", "Pengacara", "Dosen", "Guru", "Tidak Bekerja"]).pack(fill="x", padx=20, pady=5)
        
       
        
        self.pages.append(page)





    def validate_input(self):
        """Memeriksa apakah semua field wajib sudah diisi"""
        for key, entry in self.entries.items():
            if isinstance(entry, tk.Entry) and entry.get().strip() == "":
                messagebox.showwarning("Peringatan", f"Silakan isi {key}")
                return  # Menghentikan proses jika ada input kosong

            if isinstance(entry, ttk.Combobox) and entry.get().strip() == "":
                messagebox.showwarning("Peringatan", f"Silakan pilih {key}")
                return  # Menghentikan proses jika ada input kosong

            if isinstance(entry, DateEntry) and entry.get() == "":
                messagebox.showwarning("Peringatan", f"Silakan pilih {key}")
                return  # Menghentikan proses jika ada input kosong

        self.save_input()  # Jika semua data terisi, simpan dan lanjutkan
        messagebox.showinfo("Info", "Data berhasil disimpan!")
        # Anda dapat melanjutkan untuk berpindah halaman atau tindakan lain setelah berhasil menyimpan data

    def save_input(self):
        """Menyimpan inputan ke form_data"""
        for key, entry in self.entries.items():
            if isinstance(entry, tk.Entry):
                self.form_data[key] = entry.get()
            elif isinstance(entry, ttk.Combobox):
                self.form_data[key] = entry.get()
            elif isinstance(entry, DateEntry):
                self.form_data[key] = entry.get()

        print(self.form_data)  # Debug: menampilkan data yang disimpan    





    #informasi ibu
    def create_mother_info_page(self):
        page = tk.Frame(self.root, bg=self.bg_color)
        tk.Label(page, text="Informasi Ibu", font=("Times New Roman", 16, "bold"), fg="#FFFFFF",bg=self.bg_color).pack()
        
        fields = [
            "Nama Lengkap Ibu", "Nama Panggilan Ibu", "Alamat Tempat Tinggal Ibu",
            "Nomor Telepon Ibu"
        ]
        for field in fields:
            tk.Label(page, text=field,fg="#FFFFFF", bg=self.bg_color).pack(anchor="w", padx=20)
            tk.Entry(page).pack(fill="x", padx=20, pady=5)
        
        tk.Label(page, text="Pendidikan Terakhir Ibu",fg="#FFFFFF", bg=self.bg_color).pack(anchor="w", padx=20)
        ttk.Combobox(page, values=["Tidak Bersekolah","SD", "SMP", "SMA/Sederajat","D1","D2", "D3/S1", "S2", "S3"]).pack(fill="x", padx=20, pady=5)
        
        tk.Label(page, text="Pekerjaan Ibu",fg="#FFFFFF", bg=self.bg_color).pack(anchor="w", padx=20)
        ttk.Combobox(page, values=["Ibu Rumah Tangga", "Wiraswasta", "Pegawai Swasta", "Pegawai Negeri", "Dokter", "Pengacara", "Dosen", "Guru"]).pack(fill="x", padx=20, pady=5)
        self.pages.append(page)
    def validate_input(self):
        """Memeriksa apakah semua field wajib sudah diisi"""
        for key, entry in self.entries.items():
            if isinstance(entry, tk.Entry) and entry.get().strip() == "":
                messagebox.showwarning("Peringatan", f"Silakan isi {key}")
                return  # Menghentikan proses jika ada input kosong

            if isinstance(entry, ttk.Combobox) and entry.get().strip() == "":
                messagebox.showwarning("Peringatan", f"Silakan pilih {key}")
                return  # Menghentikan proses jika ada input kosong

            if isinstance(entry, DateEntry) and entry.get() == "":
                messagebox.showwarning("Peringatan", f"Silakan pilih {key}")
                return  # Menghentikan proses jika ada input kosong

        self.save_input()  # Jika semua data terisi, simpan dan lanjutkan
        messagebox.showinfo("Info", "Data berhasil disimpan!")
        # Anda dapat melanjutkan untuk berpindah halaman atau tindakan lain setelah berhasil menyimpan data

    def save_input(self):
        """Menyimpan inputan ke form_data"""
        for key, entry in self.entries.items():
            if isinstance(entry, tk.Entry):
                self.form_data[key] = entry.get()
            elif isinstance(entry, ttk.Combobox):
                self.form_data[key] = entry.get()
            elif isinstance(entry, DateEntry):
                self.form_data[key] = entry.get()

        print(self.form_data)  # Debug: menampilkan data yang disimpan   




    #info fakultas dan jurusan
    def create_faculty_info_page(self):
        page = tk.Frame(self.root, bg=self.bg_color)
        tk.Label(page, text="Fakultas dan Jurusan", font=("Times New Roman", 16, "bold"),fg="#FFFFFF", bg=self.bg_color).pack()
        
        tk.Label(page, text="Fakultas",fg="#FFFFFF", bg=self.bg_color).pack(anchor="w", padx=20)
        ttk.Combobox(page, values=["Teknologi Informasi", "Ekonomi", "Hukum", "Teknik", "Psikologi"]).pack(fill="x", padx=20, pady=5)
        
        tk.Label(page, text="Jurusan",fg="#FFFFFF", bg=self.bg_color).pack(anchor="w", padx=20)
        ttk.Combobox(page, values=["Teknik Informatika", "Sistem Informasi", "Akuntansi", "Manajemen", "Ilmu Hukum", "Teknik Sipil", "Teknik Mesin", "Teknik Elektro", "Psikologi"]).pack(fill="x", padx=20, pady=5)
        
        tk.Label(page, text="Nama Penasehat Akademik",fg="#FFFFFF", bg=self.bg_color).pack(anchor="w", padx=20)
        ttk.Combobox(page, values=["Hans Christian Marwi, S.Kom.,M.I.T", "Sean Coonery Sumarta, ST., M.Eng.", "Dr. Phie Chyan, ST., M.Cs.","Dr. Ir. N. Tri S. Saptadi, S.Kom., MT., MM., IPM.", "Stefany Y. Baralangi, S.Si., M.T.", "Ridnaldy Yunior Carolus, S.Kom., M.Kom.","Elisabeth, S.Kom., M.MSI.", "Astrid Lestari Tungadi, S.Kom., M.TI.", "Erick Alfons Lisangan, S.Kom., M.Cs.","Adi Chandra Syarif, M.Sc.", "Dr. Yanti Fristikawati, S.H., M.Hum", "Flaviana Rinta Ferdian, S.Psi., M.A.","Laurentius Purbo Christianto, S.Psi., M.A.", "Indro Adinugroho, S.Psi., M.Si.", "Dr. Christiany Suwartono, M.Si.","Dr. Angela Octavia Suryani, M.Si.", "Prof. Laura F. N. Sudarnoto.", "lainnya"]).pack(fill="x", padx=20, pady=5)
        
        self.pages.append(page)
    def validate_input(self):
        """Memeriksa apakah semua field wajib sudah diisi"""
        for key, entry in self.entries.items():
            if isinstance(entry, tk.Entry) and entry.get().strip() == "":
                messagebox.showwarning("Peringatan", f"Silakan isi {key}")
                return  # Menghentikan proses jika ada input kosong

            if isinstance(entry, ttk.Combobox) and entry.get().strip() == "":
                messagebox.showwarning("Peringatan", f"Silakan pilih {key}")
                return  # Menghentikan proses jika ada input kosong

            if isinstance(entry, DateEntry) and entry.get() == "":
                messagebox.showwarning("Peringatan", f"Silakan pilih {key}")
                return  # Menghentikan proses jika ada input kosong

        self.save_input()  # Jika semua data terisi, simpan dan lanjutkan
        messagebox.showinfo("Info", "Data berhasil disimpan!")
        # Anda dapat melanjutkan untuk berpindah halaman atau tindakan lain setelah berhasil menyimpan data

    def save_input(self):
        """Menyimpan inputan ke form_data"""
        for key, entry in self.entries.items():
            if isinstance(entry, tk.Entry):
                self.form_data[key] = entry.get()
            elif isinstance(entry, ttk.Combobox):
                self.form_data[key] = entry.get()
            elif isinstance(entry, DateEntry):
                self.form_data[key] = entry.get()

        print(self.form_data)  # Debug: menampilkan data yang disimpan        



    def on_combobox_select(self, event):
        selected_value = self.penasehat_combobox.get()
        if selected_value == "lainnya":
            self.other_name_entry.config(state="normal")  # Mengaktifkan Entry jika "lainnya" dipilih
        else:
            self.other_name_entry.config(state="disabled")  # Menonaktifkan Entry jika bukan "lainnya"

        self.pages.append(page)










    # Halaman Menampilkan Ringkasan
    def create_summary_page(self):
        page = tk.Frame(self.root, bg=self.bg_color)
        tk.Label(page, text="Ringkasan Biodata",
                  font=("Times New Roman", 16, "bold"), fg="#FFFFFF", bg=self.bg_color).pack()
        for field, widget in self.entries.items():
            if isinstance(widget, tk.Entry):
                print(f"{field}: {widget.get()}")
            elif isinstance(widget, tk.StringVar):
                print(f"{field}: {widget.get()}")
            elif isinstance(widget, DateEntry):
                print(f"{field}: {widget.get_date()}")



            








        # Create the summary text
        summary_text = "\n".join([f"{key.replace('_', ' ').capitalize()}: {value}" for key, value in self.form_data.items()])
        self.summary_label = tk.Label(page, text=summary_text, fg="#FFFFFF", bg=self.bg_color, justify="left")
        self.summary_label.pack(padx=20, pady=20)

        self.pages.append(page)


    #array untuk show sudah halaman berapa di bawah box
    def show_page(self, page_index):
        if 0 <= page_index < len(self.pages):
            self.pages[self.current_page].pack_forget()
            self.current_page = page_index
            self.pages[self.current_page].pack(expand=True, fill="both")
            self.update_navigation()








    #untuk halaman terakhir, kumpulkan untuk selesaikan program
    def update_navigation(self):
        total_pages = len(self.pages)
        self.page_label.config(text=f"Halaman {self.current_page + 1} dari {total_pages}")
        self.prev_button.config(state=tk.NORMAL if self.current_page > 0 else tk.DISABLED)
        if self.current_page == total_pages - 1:
            self.next_button.config(text="Kumpulkan", command=self.submit_form)
        else:
            self.next_button.config(text="Berikutnya", command=self.next_page)
    






    #PREVIOUS=ke halaman sebelumnya
    def previous_page(self):
        self.show_page(self.current_page - 1)
    





    #next=ke halaman berikut
    def next_page(self):
     self.save_form_data()  # Save form data before moving to next page
     self.show_page(self.current_page + 1)
    


    def save_form_data(self):
    # Save values from entry widgets to form_data
     for key, entry in self.entries.items():
        if isinstance(entry, tk.Entry):
            self.form_data[key] = entry.get()  # Save text from entry field
        elif isinstance(entry, ttk.Combobox):
            self.form_data[key] = entry.get()  # Save selected value from combobox
        elif isinstance(entry, tk.Radiobutton):
            self.form_data[key] = entry.get()  # Save selected value from radiobutton

    # Handle specific fields like DateEntry
     self.form_data['tanggal_lahir'] = self.entries['tanggal_lahir'].get_date()








    #jika sudah dikumpulkan,muncul pesan terimakasih
    def submit_form(self):
        messagebox.showinfo("Terima kasih telah mengisi biodata anda", "Formulir telah dikumpulkan ke BAA, silahkan tunggu konfirmasi lebih lanjut mengenai pembaruan data anda. Terima kasih!")
        self.root.quit()


    def print_data(self):
        # Mencetak data ke konsol (atau bisa ditampilkan dalam widget lain)
        print("Data yang Disimpan:")
        for key, value in self.form_data.items():
            print(f"{key.capitalize()}: {value}")
        
        # Alternatif: Menampilkan data di GUI
        data_window = tk.Toplevel(self.root)
        data_window.title("Data yang Disimpan")
        
        data_text = tk.Text(data_window, height=10, width=30)
        data_text.pack()
        
        for key, value in self.form_data.items():
            data_text.insert(tk.END, f"{key.capitalize()}: {value}\n")

    
    def save_data(self):
        with open('data_form.txt', 'w') as file:
           for key, value in self.form_data.items():
            file.write(f"{key.capitalize()}: {value}\n")










if __name__ == "__main__":
    root = tk.Tk()
    app = FormApp(root)
    root.mainloop()
