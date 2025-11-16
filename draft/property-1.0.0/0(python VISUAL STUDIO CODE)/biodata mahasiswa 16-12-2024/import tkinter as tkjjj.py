import tkinter as tk
from tkinter import ttk, messagebox
from PIL import Image, ImageTk
from tkcalendar import DateEntry

class FormApp:
    def __init__(self, root):
        self.root = root
        self.root.title("Formulir Biodata Mahasiswa Universitas Atma Jaya Makassar")
        self.root.geometry("800x600")
        
        # Load logo image
        try:
            logo_image = Image.open("C:/Users/arche/Downloads/uajm (1).png")
            logo_image = logo_image.resize((200, 200))
            self.logo_photo = ImageTk.PhotoImage(logo_image)
            self.root.iconphoto(True, self.logo_photo)
        except (FileNotFoundError, IOError):
            messagebox.showerror("Error", "Gambar logo tidak ditemukan.")
        
        # Colors
        self.bg_color = "#003366"
        self.border_color = "#FFD700"
        
        # Variables to store user input
        self.form_data = {
            'stambuk': tk.StringVar(),
            'nama': tk.StringVar(),
            'alamat': tk.StringVar(),
            'nomor_telepon': tk.StringVar(),
            'tempat_lahir': tk.StringVar(),
            'tanggal_lahir': tk.StringVar(),
            'agama': tk.StringVar(),
            'jenis_kelamin': tk.StringVar(),
            'status_kewarganegaraan': tk.StringVar(),
            'golongan_darah': tk.StringVar(),
            'rhesus': tk.StringVar(),
            'asal_sekolah': tk.StringVar(),
            'alamat_sekolah': tk.StringVar(),
            'nilai_nem': tk.StringVar(),
            'jurusan': tk.StringVar(),
            'nama_ayah': tk.StringVar(),
            
        }
        
        # Pages for the form
        self.pages = []
        self.current_page = 0
        
        # Create pages
        self.create_pages()
        
        # Navigation frame
        self.navigation_frame = tk.Frame(self.root, bg=self.border_color)
        self.navigation_frame.pack(side=tk.BOTTOM, fill=tk.X)
        
        self.page_label = tk.Label(self.navigation_frame, bg=self.border_color, font=("Times New Roman", 12))
        self.page_label.pack(side=tk.LEFT, padx=10)
        
        self.prev_button = tk.Button(self.navigation_frame, text="Sebelumnya", command=self.previous_page)
        self.prev_button.pack(side=tk.LEFT, padx=10)
        
        self.next_button = tk.Button(self.navigation_frame, text="Berikutnya", command=self.next_page)
        self.next_button.pack(side=tk.RIGHT, padx=10)

        # Show first page
        self.show_page(0)

    def create_pages(self):
        """Create all pages for the form."""
        self.hal1()  # Welcome Page
        self.hal2()  # Personal Information Page
        self.hal3()  # SMA/SMK Information Page
        self.hal4()  # Father's Information Page
        self.hal5()  # Mother's Information Page
        self.hal6()  # Faculty and Major Page
        self.hal7()  # Summary Page

    def show_page(self, page_index):
        """Display the specified page."""
        for page in self.pages:
            page.pack_forget()
        
        if 0 <= page_index < len(self.pages):
            self.pages[page_index].pack(fill="both", expand=True)
            self.page_label.config(text=f"Halaman {page_index + 1} dari {len(self.pages)}")
    
    def previous_page(self):
        """Go to the previous page."""
        if self.current_page > 0:
            self.current_page -= 1
            self.show_page(self.current_page)

    def next_page(self):
        """Go to the next page."""
        if self.current_page < len(self.pages) - 1:
            self.current_page += 1
            self.show_page(self.current_page)

    def hal1(self):
        """Welcome Page."""
        page = tk.Frame(self.root, bg=self.bg_color)
        
        if hasattr(self, 'logo_photo'):
            logo_label = tk.Label(page, image=self.logo_photo, bg=self.bg_color)
            logo_label.pack(pady=20)

        welcome_label = tk.Label(page, text="Selamat Datang di Universitas Atma Jaya Makassar",
                                  font=("Times New Roman", 24, "bold"), fg="#FFFFFF", bg=self.bg_color)
        welcome_label.pack(expand=True)

        self.pages.append(page)

    def hal2(self):
        """Personal Information Page."""
        page = tk.Frame(self.root, bg=self.bg_color)
        
        tk.Label(page, text="Informasi Pribadi Mahasiswa", font=("Times New Roman", 16, "bold"),
                 fg="#FFFFFF", bg=self.bg_color).pack()

        fields = [
            ("Stambuk", 'stambuk'), 
            ("Nama Lengkap", 'nama'), 
            ("Alamat", 'alamat'), 
            ("Nomor Telepon", 'nomor_telepon'), 
            ("Tempat Lahir", 'tempat_lahir')
        ]

        for label_text, var_key in fields:
            tk.Label(page, text=label_text, fg="#FFFFFF", bg=self.bg_color,
                     font=("Times New Roman", 10)).pack(anchor="w", padx=20)
            entry = tk.Entry(page, textvariable=self.form_data[var_key])
            entry.pack(fill="x", padx=20)

        # Date of Birth Entry
        tk.Label(page, text="Tanggal Lahir", fg="#FFFFFF", bg=self.bg_color,
                 font=("Times New Roman", 10)).pack(anchor="w", padx=20)
        
        calendar = DateEntry(page, width=20, date_pattern="dd/mm/yyyy",
                              background='darkblue', foreground='white', borderwidth=2,
                              textvariable=self.form_data['tanggal_lahir'])
                              
        calendar.pack(fill="x", padx=20)

         # Religion Combobox
        tk.Label(page, text="Agama", fg="#FFFFFF", bg=self.bg_color,font=("Times New Roman", 10)).pack(anchor="w", padx=20)
        agama_combobox = ttk.Combobox(page,
                                       values=["Islam", "Katolik", "Kristen",
                                               "Buddha", "Hindu", "Konghucu"],
                                       textvariable=self.form_data['agama'])
        agama_combobox.pack(fill="x", padx=20)

         # Gender Radio Buttons
        gender_frame = tk.Frame(page, bg=self.bg_color)
        gender_frame.pack(anchor="w", padx=20)

        for gender in ["Pria", "Wanita"]:
             rb = tk.Radiobutton(gender_frame,
                                 text=gender,
                                 variable=self.form_data['jenis_kelamin'],
                                 value=gender,
                                 fg="#FFD700",
                                 bg=self.bg_color)
             rb.pack(side=tk.LEFT)

         # Citizenship Status Radio Buttons
        citizenship_frame = tk.Frame(page, bg=self.bg_color)
        citizenship_frame.pack(anchor="w", padx=20)

        for status in ["WNI", "WNA"]:
             rb = tk.Radiobutton(citizenship_frame,
                                 text=status,
                                 variable=self.form_data['status_kewarganegaraan'],
                                 value=status,
                                 fg="#FFD700",
                                 bg=self.bg_color)
             rb.pack(side=tk.LEFT)

         # Blood Type Radio Buttons
        blood_type_frame = tk.Frame(page, bg=self.bg_color)
        blood_type_frame.pack(anchor="w", padx=20)

        for blood_type in ["A", "B", "AB", "O"]:
             rb = tk.Radiobutton(blood_type_frame,
                                 text=blood_type,
                                 variable=self.form_data['golongan_darah'],
                                 value=blood_type,
                                 fg="#FFD700",
                                 bg=self.bg_color)
             rb.pack(side=tk.LEFT)

         # Rhesus Radio Buttons
        rhesus_frame = tk.Frame(page, bg=self.bg_color)
        rhesus_frame.pack(anchor="w", padx=20)

        for rhesus in ["Positif", "Negatif"]:
             rb = tk.Radiobutton(rhesus_frame,
                                 text=rhesus,
                                 variable=self.form_data['rhesus'],
                                 value=rhesus,
                                 fg="#FFD700",
                                 bg=self.bg_color)
             rb.pack(side=tk.LEFT)

        self.pages.append(page)

    def hal3(self):
       """SMA/SMK Information Page."""
       page = tk.Frame(self.root, bg=self.bg_color)  
       tk.Label(page,text="Informasi SMA/SMK",
                font=("Times New Roman" ,16,"bold"),fg="#FFFFFF",
                bg=self.bg_color).pack()

       fields = [
           ("Asal SMA/SMK:", 'asal_sekolah'),
           ("Alamat SMA/SMK:", 'alamat_sekolah'),
           ("Nilai NEM:", 'nilai_nem')
       ]

       for label_text,var_key in fields:
           label =tk.Label(page,text=label_text ,fg="#FFFFFF" ,bg=self.bg_color )
           label.pack(anchor="w" ,padx=20) 
           entry=tk.Entry(page,textvariable=self.form_data[var_key])
           entry.pack(fill="x" ,padx=20,pady=5) 

       jurusan_var=tk.StringVar(value='IPA')  
       jurusan_frame=tk.Frame(page,bg=self.bg_color)  
       jurusan_frame.pack(anchor="w" ,padx=20,pady=5)  

       for jurusan in ["IPA","IPS","Yang Lain"]:  
           rb=tk.Radiobutton(jurusan_frame,text=jurusan,value=jurusan,
                             variable=jurusan_var ,fg="#FFD700" ,bg=self.bg_color)  
           rb.pack(side=tk.LEFT,padx=10)  

       other_field=tk.Entry(page,bg='white')  
       other_field.pack(anchor='w',padx=60,pady=(10 if jurusan_var.get() == "Yang Lain" else 0))  

       def show_other_field():  
           if jurusan_var.get() == "Yang Lain":  
               other_field.pack(anchor='w',padx=60,pady=(10))  
           else:  
               other_field.pack_forget()  

       jurusan_var.trace("w" ,lambda *args: show_other_field())  

       self.pages.append(page)

    def hal4(self):
        """Father's Information Page."""
        page =tk.Frame(self.root,bg=self.bg_color)  
        tk.Label(page,text="Informasi Ayah",
               font=("Times New Roman" ,16,"bold"),fg="#FFFFFF",
               bg=self.bg_color).pack()

        father_fields=[
            ("Nama Lengkap Ayah:",'nama_ayah'),
            ("Nama Panggilan Ayah:",'panggilan_ayah'),
            ("Alamat Tempat Tinggal Ayah:",'alamat_ayah'),
            ("Nomor Telepon Ayah:",'nomor_ayah')
        ]

        for label_text,var_key in father_fields:
            label=tk.Label(page,text=label_text ,fg="#FFFFFF" ,bg=self.bg_color)  
            label.pack(anchor='w',padx=20)  
            entry=tk.Entry(page,textvariable=self.form_data[var_key])  
        entry.pack(fill='x',padx=20,pady=(0 if var_key == father_fields[-1][1] else 5))  

        education_combobox=tk.ttk.Combobox(
          page ,
          values=["Tidak Bersekolah","SD","SMP","SMA/Sederajat","D1","D2","D3/S1","S2","S3"],
          textvariable=tk.StringVar(value='Pendidikan Terakhir Ayah')) 
        education_combobox.pack(fill='x',padx=20,pady=(5))  

        job_combobox=tk.ttk.Combobox(
          page ,
          values=["Wiraswasta","Pegawai Swasta","Pegawai Negeri","Dokter","Pengacara","Dosen","Guru","Tidak Bekerja"],
          textvariable=tk.StringVar(value='Pekerjaan Ayah')) 
        job_combobox.pack(fill='x',padx=20,pady=(5))  

        self.pages.append(page)

    def hal5(self):
        """Mother's Information Page."""
        page=tk.Frame(self.root,bg=self.bg_color)  
        tk.Label(page,text="Informasi Ibu",
               font=("Times New Roman" ,16,"bold"),fg="#FFFFFF",
               bg=self.bg_color).pack()

        mother_fields=[
          ("Nama Lengkap Ibu:",'nama_ibu'),
          ("Nama Panggilan Ibu:",'panggilan_ibu'),
          ("Alamat Tempat Tinggal Ibu:",'alamat_ibu'),
          ("Nomor Telepon Ibu:",'nomor_ibu')
      ]

        for label_text,var_key in mother_fields:
          label=tk.Label(page,text=label_text ,fg="#FFFFFF" ,bg=self.bg_color)  
          label.pack(anchor='w',padx=20)  
          entry=tk.Entry(page,textvariable=self.form_data[var_key])  
          entry.pack(fill='x',padx=20,pady=(0 if var_key == mother_fields[-1][1] else 5))  

        education_combobox=tk.ttk.Combobox(
          page ,
          values=["Tidak Bersekolah","SD","SMP","SMA/Sederajat","D1","D2","D3/S1","S2","S3"],
          textvariable=tk.StringVar(value='Pendidikan Terakhir Ibu')) 
        education_combobox.pack(fill='x',padx=20,pady=(5))  

        job_combobox=tk.ttk.Combobox(
          page ,
          values=["Ibu Rumah Tangga","Wiraswasta","Pegawai Swasta","Pegawai Negeri","Dokter","Pengacara","Dosen","Guru"],
          textvariable=tk.StringVar(value='Pekerjaan Ibu')) 
        job_combobox.pack(fill='x',padx=20,pady=(5))  

        self.pages.append(page)

    def hal6(self):
        """Faculty and Major Page."""
        page=tk.Frame(self.root,bg=self.bg_color)  
        tk.Label(page,text="Fakultas dan Jurusan",
               font=("Times New Roman" ,16,"bold"),fg="#FFFFFF",
               bg=self.bg_color).pack()

        faculty_combobox=tk.ttk.Combobox(
          page ,
          values=["Teknologi Informasi","Ekonomi","Hukum","Teknik","Psikologi"],
          textvariable=tk.StringVar(value='Fakultas')) 
        faculty_combobox.pack(fill='x',padx=20,pady=(5))

        major_combobox=tk.ttk.Combobox(
          page ,
          values=["Teknik Informatika","Sistem Informasi","Akuntansi",
                  "Manajemen","Ilmu Hukum","Teknik Sipil",
                  "Teknik Mesin","Teknik Elektro","Psikologi"],
          textvariable=tk.StringVar(value='Jurusan')) 
        major_combobox.pack(fill='x',padx=20,pady=(5))

        academic_advisor_combobox=tk.ttk.Combobox(
          page ,
          values=["Hans Christian Marwi,S.Kom.,M.I.T",
                  "Sean Coonery Sumarta ST.,M.Eng.",
                  "lainnya"],textvariable=tk.StringVar(value='Nama Penasehat Akademik')) 
        academic_advisor_combobox.pack(fill='x',padx=20,pady=(5))

        self.pages.append(page)

    def hal7(self):

        """Halaman Menampilkan Ringkasan"""
        page = tk.Frame(self.root, bg=self.bg_color)
        tk.Label(page, text="Konfirmasi Biodata anda", font=("Times New Roman", 11, "bold"), fg="#FFFFFF", bg=self.bg_color).pack()

    # Menampilkan data ringkasan di halaman dengan Label
        tk.Label(page, text="Stambuk: " + self.STAMBUK.get(), font=("Times New Roman", 7), fg="#FFFFFF", bg=self.bg_color).pack(anchor="w", padx=20)
        tk.Label(page, text="Nama Lengkap: " + self.NAMA.get(), font=("Times New Roman", 7), fg="#FFFFFF", bg=self.bg_color).pack(anchor="w", padx=20)
        tk.Label(page, text="Alamat: " + self.ALAMAT.get(), font=("Times New Roman", 7), fg="#FFFFFF", bg=self.bg_color).pack(anchor="w", padx=20)
        tk.Label(page, text="Nomor Telepon: " + self.NOMOR.get(), font=("Times New Roman", 7), fg="#FFFFFF", bg=self.bg_color).pack(anchor="w", padx=20)
        tk.Label(page, text="Tempat Lahir: " + self.TEMPAT.get(), font=("Times New Roman", 7), fg="#FFFFFF", bg=self.bg_color).pack(anchor="w", padx=20)
        tk.Label(page, text="Tanggal Lahir: " + self.TANGGAL.get(), font=("Times New Roman", 7), fg="#FFFFFF", bg=self.bg_color).pack(anchor="w", padx=20)
        tk.Label(page, text="Agama: " + self.AGAMA.get(), fg="#FFFFFF", font=("Times New Roman", 7), bg=self.bg_color).pack(anchor="w", padx=20)

    # Tambahkan label lainnya sesuai kebutuhan
        self.pages.append(page)


if __name__ == "__main__":
    root = tk.Tk()
    app = FormApp(root)
    root.mainloop()
