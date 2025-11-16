import tkinter as tk
from tkinter import messagebox

class Application(tk.Tk):
    def __init__(self):
        super().__init__()
        self.title("Formulir Data Mahasiswa")
        self.geometry("600x500")
        self.current_page = 0
        self.data = [None] * 33  # Array untuk menyimpan data mahasiswa
        self.pages = [
            self.welcome_page,
            self.personal_info_page,
            self.highschool_info_page,
            self.father_info_page,
            self.mother_info_page,
            self.faculty_info_page,
            self.confirmation_page,
            self.thank_you_page
        ]
        self.show_page()

    def show_page(self):
        for widget in self.winfo_children():
            widget.destroy()
        self.pages[self.current_page]()

    def welcome_page(self):
        frame = tk.Frame(self, bg="#ADD8E6")
        frame.pack(fill=tk.BOTH, expand=True)

        label = tk.Label(frame, text="Selamat Datang di Universitas Atma Jaya", bg="#ADD8E6", font=("Arial", 16))
        label.pack(pady=20)

        next_button = tk.Button(frame, text="Berikutnya", command=self.next_page)
        next_button.pack(pady=10)

    def personal_info_page(self):
        frame = tk.Frame(self, bg="#ADD8E6")
        frame.pack(fill=tk.BOTH, expand=True)

        tk.Label(frame, text="Data Diri Mahasiswa", bg="#ADD8E6", font=("Arial", 14)).pack(pady=10)

        labels = [
            "Stambuk:", "Nama Lengkap:", "Alamat:", "Nomor Telepon:",
            "Tempat Lahir:", "Tanggal Lahir (DD/MM/YYYY):", "Agama:",
            "Jenis Kelamin:", "Status Kewarganegaraan:", "Golongan Darah:", "Rhesus:"
        ]

        for i, label in enumerate(labels):
            tk.Label(frame, text=label, bg="#ADD8E6").grid(row=i, column=0, sticky="w", padx=10)
            if label == "Tanggal Lahir (DD/MM/YYYY):":
                entry = tk.Entry(frame)
                entry.grid(row=i, column=1)
                self.data[i] = entry
            elif label in ["Agama:", "Jenis Kelamin:", "Status Kewarganegaraan:", "Golongan Darah:", "Rhesus:"]:
                var = tk.StringVar()
                options = {
                    "Agama:": ["Islam", "Katolik", "Kristen", "Buddha", "Hindu"],
                    "Jenis Kelamin:": ["Pria", "Wanita"],
                    "Status Kewarganegaraan:": ["WNI", "WNA"],
                    "Golongan Darah:": ["A", "B", "AB", "O"],
                    "Rhesus:": ["+", "-"]
                }
                for j, option in enumerate(options[label]):
                    tk.Radiobutton(frame, text=option, variable=var, value=option).grid(row=i, column=j+1)
                self.data[i] = var
            else:
                entry = tk.Entry(frame)
                entry.grid(row=i, column=1)
                self.data[i] = entry

        tk.Button(frame, text="Sebelumnya", command=self.previous_page).grid(row=len(labels), column=0, pady=20)
        tk.Button(frame, text="Berikutnya", command=self.next_page).grid(row=len(labels), column=1)

    def highschool_info_page(self):
        frame = tk.Frame(self, bg="#ADD8E6")
        frame.pack(fill=tk.BOTH, expand=True)

        tk.Label(frame, text="Informasi SMA/SMK", bg="#ADD8E6", font=("Arial", 14)).pack(pady=10)

        labels = [
            "Asal SMA/SMK:", "Alamat SMA/SMK:", 
            "Jurusan SMA:", "Nilai NEM:"
        ]
        
        for i, label in enumerate(labels):
            tk.Label(frame, text=label, bg="#ADD8E6").grid(row=i, column=0, sticky="w", padx=10)
            if label == "Jurusan SMA:":
                var = tk.StringVar()
                options = ["IPA", "IPS", "Yang lain (isi sendiri)"]
                for j, option in enumerate(options):
                    tk.Radiobutton(frame, text=option, variable=var, value=option).grid(row=i, column=j+1)
                self.data[12 + i] = var
            else:
                entry = tk.Entry(frame)
                entry.grid(row=i, column=1)
                self.data[12 + i] = entry

        tk.Button(frame, text="Sebelumnya", command=self.previous_page).grid(row=len(labels), column=0, pady=20)
        tk.Button(frame, text="Berikutnya", command=self.next_page).grid(row=len(labels), column=1)

    def father_info_page(self):
        frame = tk.Frame(self, bg="#ADD8E6")
        frame.pack(fill=tk.BOTH, expand=True)

        tk.Label(frame, text="Informasi Ayah", bg="#ADD8E6", font=("Arial", 14)).pack(pady=10)

        labels = [
            "Nama Lengkap Ayah:", "Nama Panggilan Ayah:",
            "Pendidikan Terakhir Ayah:", "Pekerjaan Ayah:",
            "Nomor Telepon Ayah:", "Alamat Tempat Tinggal Ayah:"
        ]

        for i, label in enumerate(labels):
            tk.Label(frame, text=label, bg="#ADD8E6").grid(row=i, column=0, sticky="w", padx=10)
            if label in ["Pendidikan Terakhir Ayah:", "Pekerjaan Ayah:"]:
                var = tk.StringVar()
                options = {
                    "Pendidikan Terakhir Ayah:": ["SD", "SMP", "SMA", "S1", "S2", "S3"],
                    "Pekerjaan Ayah:": ["Wiraswasta", "Pegawai Swasta",
                                       "Pegawai Negeri",
                                       "Dokter",
                                       "Pengacara",
                                       "Dosen",
                                       "Guru",
                                       "Tidak Bekerja"]
                }
                for j, option in enumerate(options[label]):
                    tk.Radiobutton(frame, text=option, variable=var, value=option).grid(row=i, column=j+1)
                self.data[16 + i] = var
            else:
                entry = tk.Entry(frame)
                entry.grid(row=i, column=1)
                self.data[16 + i] = entry

        tk.Button(frame, text="Sebelumnya", command=self.previous_page).grid(row=len(labels), column=0, pady=20)
        tk.Button(frame, text="Berikutnya", command=self.next_page).grid(row=len(labels), column=1)

    def mother_info_page(self):
        frame = tk.Frame(self, bg="#ADD8E6")
        frame.pack(fill=tk.BOTH, expand=True)

        tk.Label(frame, text="Informasi Ibu", bg="#ADD8E6", font=("Arial", 14)).pack(pady=10)

        labels = [
            "Nama Lengkap Ibu:", 
            "Nama Panggilan Ibu:",
            "Pendidikan Terakhir Ibu:", 
            "Pekerjaan Ibu:", 
            "Nomor Telepon Ibu:", 
            "Alamat Tempat Tinggal Ibu:"
        ]

        for i,label in enumerate(labels):
             tk.Label(frame,text,label,bg='#ADD8E6').grid(row=i,column=(0),sticky='w',padx=(10))
             if label in ['Pendidikan Terakhir Ibu:', 'Pekerjaan Ibu:']:
                 var=tk.StringVar()
                 options={
                     'Pendidikan Terakhir Ibu:': ['SD', 'SMP', 'SMA', 'S1', 'S2', 'S3'],
                     'Pekerjaan Ibu:': ['Ibu Rumah Tangga','Wiraswasta','Pegawai Swasta','Pegawai Negeri','Dokter','Pengacara','Dosen','Guru']
                 }
                 for j , option in enumerate(options[label]):
                     tk.Radiobutton(frame,text='option',variable='var',value='option').grid(row=i,column=j+1)
                 self.data[22+i]=var
             else:
                 entry=tk.Entry(frame)
                 entry.grid(row=i,column=(1))
                 self.data[22+i]=entry

         # Navigation buttons
        tk.Button(frame,text='Sebelumnya',command=self.previous_page).grid(row=len(labels),column=(0),pady=(20))
        tk.Button(frame,text='Berikutnya',command=self.next_page).grid(row=len(labels),column=(1))

    def faculty_info_page(self):
         frame=tk.Frame(self,bg='#ADD8E6')
         frame.pack(fill=tk.BOTH ,expand=True)

         labels=[
             'Fakultas:', 'Jurusan:', 'Nama Penasehat Akademik:'
         ]

         for i,label in enumerate(labels):
             tk.Label(frame,text,label,bg='#ADD8E6').grid(row=i,column=(0),sticky='w',padx=(10))
             if label=='Fakultas:' :
                 var=tk.StringVar()
                 options=['Teknologi Informasi','Ekonomi','Hukum','Teknik','Psikologi']
                 for j , option in enumerate(options):
                     tk.Radiobutton(frame,text='option',variable='var',value='option').grid(row=i,column=j+1)
                 self.data[31+i]=var
             elif label=='Jurusan:':
                 var=tk.StringVar()
                 options=['Teknik Informatika','Sistem Informasi','Akuntansi','Manajemen','Ilmu Hukum',
                          'Teknik Sipil','Teknik Mesin','Teknik Elektro','Psikologi']
                 for j , option in enumerate(options):
                     tk.Radiobutton(frame,text='option',variable='var',value='option').grid(row=i,column=j+1)
                 self.data[32+i]=var
             else:
                 entry=tk.Entry(frame)
                 entry.grid(row=i,column=(1))
                 self.data[32+i]=entry

         # Navigation buttons
         tk.Button(frame,text='Sebelumnya',command=self.previous_page).grid(row=len(labels),column=(0),pady=(20))
         tk.Button(frame,text='Kumpulkan',command=self.confirmation_page).grid(row=len(labels),column=(1))

    def confirmation_page(self):
         frame=tk.Frame(self,bg='#ADD8E6')
         frame.pack(fill=tk.BOTH ,expand=True)

         confirmation_text='Konfirmasi Data:\n\n'
         for index,value in enumerate(self.data):
             confirmation_text+=f'{index+1}. {value.get() if isinstance(value,str) else value.get()}\n'
         
         label=tk.Label(frame,text='Konfirmasi Data Anda:',bg='#ADD8E6',font=('Arial',14))
         label.pack(pady=(10))

         confirmation_label=tk.Label(frame,text=text,bg='#ADD8E6')
         confirmation_label.pack(pady=(10))

         # Navigation buttons
         button_frame=tk.Frame(frame,bg='#ADD8E6')
         button_frame.pack(pady=(20))
         
         button_simpan=tk.Button(button_frame,text='Simpan',command=self.thank_you_page)
         button_simpan.grid(column=(0),padx=(5))
         
         button_edit=tk.Button(button_frame,text='Edit Data',command=lambda:self.show_previous())
         button_edit.grid(column=(1),padx=(5))

    def thank_you_page(self):
          frame=tk.Frame(self,bg='#ADD8E6')
          frame.pack(fill=tk.BOTH ,expand=True)

          label=tk.Label(frame,text='Terima Kasih!',bg='#ADD8E6',font=('Arial',16))
          label.pack(pady=(20))

          exit_button=tk.Button(frame,text='Keluar',command=self.quit)
          exit_button.pack(pady=(10))

    def next_page(self):
          if self.current_page < len(self.pages) - 1:
              self.current_page += 1
              self.show_page()

    def previous_page(self):
          if self.current_page > 0:
              self.current_page -= 1
              self.show_page()

if __name__ == "__main__":
    app = Application()
    app.mainloop()
