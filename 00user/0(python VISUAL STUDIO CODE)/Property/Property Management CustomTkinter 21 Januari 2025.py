# Copyright (c) 2025 [Vincentius Bryan Kwandou]
# All rights reserved.
# Unauthorized use, modification, or distribution of this software is prohibited.
# Licensed under the MIT License. See the LICENSE file for details.











import customtkinter as ctk
from tkcalendar import DateEntry
from PIL import Image, ImageTk , ImageDraw
from tkinter import filedialog
import webbrowser
import os 
import re
import matplotlib.pyplot as plt
from matplotlib.backends.backend_tkagg import FigureCanvasTkAgg
from PIL import Image
from tkinter import PhotoImage  
from customtkinter import CTkImage
from tkinter import PhotoImage

# Initialize theme and application

# Set appearance mode to dark or light
ctk.set_appearance_mode("system")  # Options: "light", "dark", or "system"

# Set default color theme

ctk.set_default_color_theme("green")  # Options: "blue", "dark-blue", or "green"














class PropertyApp(ctk.CTk):
    def __init__(self):
        super().__init__()
        self.title("NNG Property App")
        self.iconbitmap(r"C:\\Users\\arche\\0(python VISUAL STUDIO CODE)\\Property\\logo2.ico")
        self.geometry("900x600")


      



        # Create a dictionary to store frames
        self.frames = {}

        # List of frames to be used
        self.frame_classes = [
            LoginFrame,CreateAccountFrame,ForgotAccountFrame, SPropertyListFrame, SAddPropertyFrame,BPropertyListFrame, BAddPropertyFrame,
            SalesDashboardFrame, BuyerDashboardFrame,BEditProfileFrame,BViewProfileFrame,SEditProfileFrame,SViewProfileFrame, ContactSalesFrame, ChatbotFrame, SLogoutFrame, BLogoutFrame,DeveloperDashboardFrame,
            SalesStatisticsFrame,EditPropertyFrame,AddPropertyFrame,PropertyListFrame,EditUserInfoFrame,UserInfoFrame,SEditPropertyFrame,BEditPropertyFrame
        ]

        # Initialize all frames
        for F in self.frame_classes:
            frame_name = F.__name__
            frame = F(parent=self, controller=self)
            self.frames[frame_name] = frame
            frame.grid(row=0, column=0, sticky="nsew")

        # Configure grid weights for resizing
        self.grid_rowconfigure(0, weight=1)
        self.grid_columnconfigure(0, weight=1)

        # Show login frame first
        self.show_frame("LoginFrame")




    def show_frame(self, frame_name):
        frame = self.frames[frame_name]
        frame.tkraise()

  


















# Frame Login
class LoginFrame(ctk.CTkFrame):
    def __init__(self, parent, controller):
        super().__init__(parent)
        self.controller = controller
        

        logo_path = r"C:\\Users\\arche\\0(python VISUAL STUDIO CODE)\\Property\\nngp.jpg"  # Use raw string for Windows path
        self.logo_image = Image.open(logo_path)
        self.logo_image = self.logo_image.resize((250, 250), Image.LANCZOS)  # Resize if needed
        self.logo_photo = ImageTk.PhotoImage(self.logo_image)

        # Display logo in the frame
        
        if self.logo_photo:
            self.logo_label = ctk.CTkLabel(self, image=self.logo_photo)
            self.logo_label.pack(pady=0)


        ctk.CTkLabel(self, text="Login", font=("Arial", 24)).pack(pady=5)

        # Role selection
        self.role_var = ctk.StringVar(value="buyer")  # Default role is buyer
        ctk.CTkRadioButton(self, text="Login Sebagai Agen", variable=self.role_var, value="sales").pack(pady=1)
        ctk.CTkRadioButton(self, text="Login Sebagai User", variable=self.role_var, value="buyer").pack(pady=1)
        ctk.CTkRadioButton(self, text="Login Sebagai Developer/Owner", variable=self.role_var, value="developer").pack(pady=1)  # New role option




        self.username_entry = ctk.CTkEntry(self, placeholder_text="Username", width=200)  # Set width to 200 pixels
        self.username_entry.pack(pady=5, padx=20)  # Fill horizontally

        self.password_entry = ctk.CTkEntry(self, placeholder_text="Password", show="*", width=200)  # Set width to 200 pixels
        self.password_entry.pack(pady=5, padx=20)  # Fill horizontally

        self.login_button = ctk.CTkButton(self, text="Login", command=self.login)
        self.login_button.pack(pady=0)

        # Label for displaying error messages
        self.error_label = ctk.CTkLabel(self, text="", text_color="red")
        self.error_label.pack(pady=0)

        self.forgot_account_label = ctk.CTkLabel(self, text="Lupa Username dan Password?", text_color="white", font=("Arial", 10, "underline"), cursor="hand2")
        self.forgot_account_label.pack(pady=(0))

# Menambahkan fungsi untuk mengubah frame saat label diklik
        self.forgot_account_label.bind("<Button-1>", lambda e: controller.show_frame("ForgotAccountFrame"))


        ctk.CTkLabel(self, text="Atau Login Menggunakan:", font=("Arial", 11)).pack(pady=(0, 0))


        social_frame = ctk.CTkFrame(self)
        social_frame.pack(pady=0)

        # Load social media logos
        google_logo = Image.open(r"C:\\Users\\arche\\0(python VISUAL STUDIO CODE)\\Property\\g.jpg" ).resize((30, 30), Image.LANCZOS)  # Update with actual path
        facebook_logo = Image.open(r"C:\\Users\\arche\\0(python VISUAL STUDIO CODE)\\Property\\f.jpg" ).resize((30, 30), Image.LANCZOS)  # Update with actual path
        x_logo = Image.open(r"C:\\Users\\arche\\0(python VISUAL STUDIO CODE)\\Property\\x.jpg" ).resize((30, 30), Image.LANCZOS)  # Update with actual path

        # Convert images to PhotoImage
        self.google_photo = ImageTk.PhotoImage(google_logo)
        self.facebook_photo = ImageTk.PhotoImage(facebook_logo)
        self.x_photo = ImageTk.PhotoImage(x_logo)

        # Create buttons for social media login
        google_button = ctk.CTkButton(social_frame, image=self.google_photo, text=" Google", command=self.login_with_google)
        google_button.pack(side='left', padx=(0, 10), pady=(0,0))

        facebook_button = ctk.CTkButton(social_frame, image=self.facebook_photo, text=" Facebook", command=self.login_with_facebook)
        facebook_button.pack(side='left', padx=(10, 10), pady=(0,0))

        x_button = ctk.CTkButton(social_frame, image=self.x_photo, text=" X", command=self.login_with_x)
        x_button.pack(side='left', padx=(10, 0), pady=(0,0))

# Center the social_frame in the parent frame
        social_frame.pack(expand=True) 



        separator_label = ctk.CTkLabel(self, text="Atau", text_color="white", font=("Arial", 12))
        separator_label.pack(pady=0)


        self.create_account_button = ctk.CTkButton(self, text="Buat Akun", command=lambda: controller.show_frame("CreateAccountFrame"))
        self.create_account_button.pack(pady=0)

        self.copyright_label = ctk.CTkLabel(self, text="Copyright 2010-2025 NNG Property by nayrbryanGaming Official. All rights reserved.", text_color="white", font=("Arial", 10))
        self.copyright_label.pack(side='bottom', pady=0)  # Position at the bottom with some padding


        toggle_frame = ctk.CTkFrame(self, width=150, height=50)  # Set desired width and height
        toggle_frame.pack(side='bottom', anchor='sw', padx=(10, 0), pady=(10, 10))  # Anchor to the bottom left

        # Toggle theme switch
        self.theme_switch = ctk.CTkSwitch(toggle_frame, text="Mode Gelap/Terang", command=self.toggle_theme)
        self.theme_switch.pack(side='left', padx=(20, 10))

        


        self.credentials = {
            "vin": "vin",  # Sales
            "vincent": "vincent",  # Buyer
            "": "",
            "x": "x",
            ".": ".",
            " ": " ",
            # Tambahkan lebih banyak username dan password sesuai kebutuhan
        }


    def load_image(self, path):
        """Load an image and handle errors."""
        try:
            if not os.path.exists(path):
                raise FileNotFoundError(f"File not found: {path}")
            
            img = Image.open(path)
            img = img.resize((250, 250), Image.LANCZOS)  # Resize if needed
            return ImageTk.PhotoImage(img)
        
        except Exception as e:
            print(f"Error loading image: {e}")
            return None






    def toggle_theme(self):
        """Toggle between dark and light theme."""
        if self.theme_switch.get():  # If switch is on (dark mode)
            ctk.set_appearance_mode("dark")
        # Optional: Set dark background color if needed
            self.configure(bg='black')  
            for widget in self.winfo_children():
                widget.configure(bg='black', fg='white')  # Update child widgets' colors
        else:  # If switch is off (light mode)
            ctk.set_appearance_mode("light")
        # Change background color to light blue for light mode
            self.configure(bg='lightblue')  
            for widget in self.winfo_children():
                widget.configure(bg='lightblue', fg='black')  # Update child widgets' colors








    def login(self):
        entered_username = self.username_entry.get()
        entered_password = self.password_entry.get()
        
        selected_role = self.role_var.get()  # Get selected role

        # Cek apakah username ada dalam credentials
        if entered_username in self.credentials:
            if self.credentials[entered_username] == entered_password:
                if selected_role == "sales":
                    self.controller.show_frame("SalesDashboardFrame")  # Show Sales Dashboard
                    self.error_label.configure(text="", text_color="red")
                elif selected_role == "buyer":
                    self.controller.show_frame("BuyerDashboardFrame")  # Show Buyer Dashboard
                    self.error_label.configure(text="", text_color="red")
                elif selected_role == "developer":
            # Implement developer login logic here
                    self.controller.show_frame("DeveloperDashboardFrame")  # Show Developer Dashboard
                    self.error_label.configure(text="", text_color="red")
            else:
                self.error_label.configure(text="Username dan Password tidak sesuai!")
        else:
            self.error_label.configure(text="Username Ini tidak ada! Mohon Pastikan Anda Mengisi dengan Benar!")









    def login_with_google(self):
        """Open Google login page in web browser."""
        url = "https://accounts.google.com/signin"
        webbrowser.open(url)

    def login_with_facebook(self):
        """Open Facebook login page in web browser."""
        url = "https://www.facebook.com/login"
        webbrowser.open(url)

    def login_with_x(self):
        """Open X (Twitter) login page in web browser."""
        url = "https://twitter.com/login"
        webbrowser.open(url)




















class ForgotAccountFrame(ctk.CTkFrame):
    def __init__(self, parent, controller):
        super().__init__(parent)
        self.controller = controller

        ctk.CTkLabel(self, text="Opsi Pemulihan Akun", font=("Arial", 24)).pack(pady=20)

        ctk.CTkLabel(self, text="Masukkan Alamat Email Anda:", font=("Arial", 14)).pack(pady=10)

        frame = ctk.CTkFrame(self)
        frame.pack(pady=10)

        ctk.CTkLabel(frame, text="Masukkan Alamat Email Anda:", font=("Arial", 14)).pack(pady=10)

        self.email_entry = ctk.CTkEntry(frame, placeholder_text="EmailAnda@domain.com", width=250)  # Set width to 250 pixels
        self.email_entry.pack(pady=10)

        self.recover_button = ctk.CTkButton(frame, text="Pulihkan Akun", command=self.recover_account, width=250)  # Set width to 250 pixels
        self.recover_button.pack(pady=20)

        self.message_label = ctk.CTkLabel(self, text="", text_color="red")
        self.message_label.pack(pady=5)


        ctk.CTkButton(self, text="Coba Cara Lain", command=self.show_alternative_recovery).pack(pady=10)


        ctk.CTkButton(self, text="Kembali ke Halaman Login", command=lambda: controller.show_frame("LoginFrame")).pack(pady=10)







    def recover_account(self):
        entered_email = self.email_entry.get()
        
        # Here you would typically check if the email exists in your database
        if entered_email:  # Simulating an email check
            self.message_label.configure(text="Kode Username dan Password Telah Dikirimkan ke Email anda, Silahkan Masukkan Pada halaman Login", text_color="white")
        else:
            self.message_label.configure(text="""Maaf, Alamat Email Anda Tidak Ditemukan, Pastikan Anda Memasukkan Format Yang Benar
Contoh Format Email Yang Benar : VinBryYT@gmail.com""", text_color="red")









    def show_alternative_recovery(self):
        """Show alternative recovery options."""
        for widget in self.winfo_children():
            widget.pack_forget()  # Hide all current widgets

        ctk.CTkLabel(self, text="Masukkan Nomor Telepon Anda:", font=("Arial", 14)).pack(pady=10)

        self.phone_entry = ctk.CTkEntry(self, placeholder_text="Nomor Telepon Anda", width=250)
        self.phone_entry.pack(pady=10)

        self.verification_code_entry = ctk.CTkEntry(self, placeholder_text="Kode Verifikasi", width=250)
        self.verification_code_entry.pack(pady=10)

        self.verify_button = ctk.CTkButton(self, text="Verifikasi", command=self.verify_code)
        self.verify_button.pack(pady=20)

        ctk.CTkButton(self, text="Kembali ke Halaman Login", command=lambda: self.controller.show_frame("LoginFrame")).pack(pady=10)
        


    def verify_code(self):
        """Verify the entered verification code."""
        phone_number = self.phone_entry.get()
        verification_code = self.verification_code_entry.get()

        # Simulate verification logic (replace with actual logic)
        if phone_number and verification_code:
            # Here you would typically check the verification code against your database
            if verification_code == "123456":  # Example of a hardcoded valid code
                self.message_label.configure(text="Verifikasi berhasil! Silakan masukkan username dan password baru.", text_color="green")
                self.show_new_credentials_fields()
            else:
                self.message_label.configure(text="Kode verifikasi salah!", text_color="red")
        else:
            self.message_label.configure(text="Harap masukkan nomor telepon dan kode verifikasi!", text_color="red")

        





    def show_new_credentials_fields(self):
        """Show fields for entering new username and password."""
        for widget in self.winfo_children():
            widget.pack_forget()  # Hide all current widgets

        ctk.CTkLabel(self, text="Masukkan Username Baru:", font=("Arial", 14)).pack(pady=10)
        
        self.new_username_entry = ctk.CTkEntry(self, placeholder_text="Username Baru", width=250)
        self.new_username_entry.pack(pady=10)

        ctk.CTkLabel(self, text="Masukkan Password Baru:", font=("Arial", 14)).pack(pady=10)

        self.new_password_entry = ctk.CTkEntry(self, placeholder_text="Password Baru", show='*', width=250)
        self.new_password_entry.pack(pady=10)

        self.submit_new_credentials_button = ctk.CTkButton(self, text="Kirim", command=self.submit_new_credentials)
        self.submit_new_credentials_button.pack(pady=20)
        ctk.CTkButton(self, text="Kembali ke Halaman Login", command=lambda: self.controller.show_frame("LoginFrame")).pack(pady=10)






    def submit_new_credentials(self):
        """Submit new username and password."""
        new_username = self.new_username_entry.get()
        new_password = self.new_password_entry.get()

        # Here you would typically save the new credentials to your database
        if new_username and new_password:
            self.message_label.configure(text="Username dan password baru berhasil disimpan!", text_color="green")
            # Optionally reset the frame or go back to login
            # You can call controller.show_frame("LoginFrame") here if needed
            for widget in self.winfo_children():
                widget.pack_forget()  # Hide all current widgets
            ctk.CTkLabel(self, text="Akun berhasil diperbarui!", font=("Arial", 18)).pack(pady=20)
            ctk.CTkButton(self, text="Kembali ke Halaman Login", command=lambda: self.controller.show_frame("LoginFrame")).pack(pady=10)

    




















class CreateAccountFrame(ctk.CTkFrame):
    def __init__(self, parent, controller):
        super().__init__(parent)
        self.controller = controller

        scrollable_frame = ctk.CTkScrollableFrame(self)
        scrollable_frame.pack(expand=True, fill="both", padx=20, pady=20)

        self.username_entry = ctk.CTkEntry(scrollable_frame, placeholder_text="Username", width=200)
        self.username_entry.pack(pady=1, padx=20)

        self.full_name_entry = ctk.CTkEntry(scrollable_frame, placeholder_text="Nama Lengkap", width=200)
        self.full_name_entry.pack(pady=1, padx=20)

        self.nickname_entry = ctk.CTkEntry(scrollable_frame, placeholder_text="Nama Panggilan", width=200)
        self.nickname_entry.pack(pady=1, padx=20)

        self.email_entry = ctk.CTkEntry(scrollable_frame, placeholder_text="Email", width=200)
        self.email_entry.pack(pady=1, padx=20)





        self.phone_frame = ctk.CTkFrame(scrollable_frame)
        self.phone_frame.pack(pady=1, padx=10)
        
        # Country code dropdown (example)
        self.country_code_var = ctk.StringVar(value="+62")  # Default to Indonesia
        country_codes = ["+62","+63","+64","+65","+66","+67","+68","+69","+70","+71","+72","+73","+74","+75","+76","+77","+78","+79","+80","+81","+82","+83","+84","+85","+86","+87","+88","+89"]  # Add more codes as needed
        ctk.CTkOptionMenu(self.phone_frame, variable=self.country_code_var, values=country_codes).pack(side='left')

        self.phone_entry = ctk.CTkEntry(self.phone_frame, placeholder_text="Nomor Telepon", width=150)
        self.phone_entry.pack(side='right', padx=(5, 0))





        # Date of Birth using tkcalendar DateEntry
        ctk.CTkLabel(scrollable_frame, text="Tanggal Lahir").pack(pady=(0))
        self.dob_entry = DateEntry(scrollable_frame, width=30)
        self.dob_entry.pack(pady=0)

        self.nik_entry = ctk.CTkEntry(scrollable_frame, placeholder_text="NIK", width=200)
        self.nik_entry.pack(pady=1, padx=20)

        self.npwp_entry = ctk.CTkEntry(scrollable_frame, placeholder_text="NPWP", width=200)
        self.npwp_entry.pack(pady=1, padx=20)

        self.password_entry = ctk.CTkEntry(scrollable_frame, placeholder_text="Password", show="*", width=200)
        self.password_entry.pack(pady=1, padx=20)

        self.confirm_password_entry = ctk.CTkEntry(scrollable_frame, placeholder_text="Konfirmasi Password", show="*", width=200)
        self.confirm_password_entry.pack(pady=1, padx=20)

        # Radio buttons for user type
        self.role_var = ctk.StringVar(value="user")  # Default role is user
        ctk.CTkRadioButton(scrollable_frame, text="Daftar sebagai User", variable=self.role_var, value="user").pack(pady=(1))
        ctk.CTkRadioButton(scrollable_frame, text="Daftar sebagai Sales", variable=self.role_var, value="sales").pack(pady=(1))

        self.create_account_button = ctk.CTkButton(scrollable_frame, text="Buat Akun", command=self.create_account)
        self.create_account_button.pack(pady=10)

        self.message_label = ctk.CTkLabel(scrollable_frame, text="", text_color="red")
        self.message_label.pack(pady=5)

       
        ctk.CTkLabel(scrollable_frame, text="Atau Daftar Menggunakan:", font=("Arial", 14)).pack(pady=(0, 0))


        social_frame = ctk.CTkFrame(scrollable_frame)
        social_frame.pack(pady=0)

        # Load social media logos
        google_logo = Image.open(r"C:\\Users\\arche\\0(python VISUAL STUDIO CODE)\\Property\\g.jpg" ).resize((30, 30), Image.LANCZOS)  # Update with actual path
        facebook_logo = Image.open(r"C:\\Users\\arche\\0(python VISUAL STUDIO CODE)\\Property\\f.jpg" ).resize((30, 30), Image.LANCZOS)  # Update with actual path
        x_logo = Image.open(r"C:\\Users\\arche\\0(python VISUAL STUDIO CODE)\\Property\\x.jpg" ).resize((30, 30), Image.LANCZOS)  # Update with actual path

        # Convert images to PhotoImage
        self.google_photo = ImageTk.PhotoImage(google_logo)
        self.facebook_photo = ImageTk.PhotoImage(facebook_logo)
        self.x_photo = ImageTk.PhotoImage(x_logo)

        # Create buttons for social media login
        google_button = ctk.CTkButton(social_frame, image=self.google_photo, text=" Google", command=self.login_with_google)
        google_button.pack(side='left', padx=(0, 10), pady=(0,0))

        facebook_button = ctk.CTkButton(social_frame, image=self.facebook_photo, text=" Facebook", command=self.login_with_facebook)
        facebook_button.pack(side='left', padx=(10, 10), pady=(0,0))

        x_button = ctk.CTkButton(social_frame, image=self.x_photo, text=" X", command=self.login_with_x)
        x_button.pack(side='left', padx=(10, 0), pady=(0,0))

# Center the social_frame in the parent frame
        social_frame.pack(expand=True) 


        ctk.CTkButton(self, text="Kembali ke Halaman Login", command=lambda: controller.show_frame("LoginFrame")).pack(pady=10)





    def create_account(self):
        username = self.username_entry.get()
        password = self.password_entry.get()
        confirm_password = self.confirm_password_entry.get()

        if password != confirm_password:
            self.message_label.configure(text="Password tidak sesuai!")
            return
        
        # Simpan akun baru (logika penyimpanan belum diimplementasikan)
        # Misalnya: simpan ke database atau dictionary
        # ...
        
        self.message_label.configure(text="Akun berhasil dibuat! Silakan login.", text_color="white")


    def login_with_google(self):
        """Open Google login page in web browser."""
        url = "https://accounts.google.com/signin"
        webbrowser.open(url)

    def login_with_facebook(self):
        """Open Facebook login page in web browser."""
        url = "https://www.facebook.com/login"
        webbrowser.open(url)

    def login_with_x(self):
        """Open X (Twitter) login page in web browser."""
        url = "https://twitter.com/login"
        webbrowser.open(url)





























# Frame Dashboard
class SalesDashboardFrame(ctk.CTkFrame):
    def __init__(self, parent, controller):
        super().__init__(parent)
        self.controller = controller

        ctk.CTkLabel(self, text="Selamat Datang Di Dashboard Agen Property", font=("Arial", 24)).pack(pady=0)



        scrollable_frame = ctk.CTkScrollableFrame(self)
        scrollable_frame.pack(expand=True, fill="both", padx=0, pady=0)


        # List of logo images for the slideshow
        self.logo_images = [
            r"C:\\Users\\arche\\0(python VISUAL STUDIO CODE)\\Property\\1.jpg",
            r"C:\\Users\\arche\\0(python VISUAL STUDIO CODE)\\Property\\2.jpg",
            r"C:\\Users\\arche\\0(python VISUAL STUDIO CODE)\\Property\\3.jpg",
            r"C:\\Users\\arche\\0(python VISUAL STUDIO CODE)\\Property\\4.jpg",
            r"C:\\Users\\arche\\0(python VISUAL STUDIO CODE)\\Property\\5.jpg",
            r"C:\\Users\\arche\\0(python VISUAL STUDIO CODE)\\Property\\6.jpg",
            r"C:\\Users\\arche\\0(python VISUAL STUDIO CODE)\\Property\\7.jpg",
            r"C:\\Users\\arche\\0(python VISUAL STUDIO CODE)\\Property\\8.jpg",
            r"C:\\Users\\arche\\0(python VISUAL STUDIO CODE)\\Property\\9.jpg",
            r"C:\\Users\\arche\\0(python VISUAL STUDIO CODE)\\Property\\10.jpg",
            r"C:\\Users\\arche\\0(python VISUAL STUDIO CODE)\\Property\\11.jpg",
            r"C:\\Users\\arche\\0(python VISUAL STUDIO CODE)\\Property\\12.jpg",
            r"C:\\Users\\arche\\0(python VISUAL STUDIO CODE)\\Property\\13.jpg"
        ]
        
        self.current_image_index = 0  # Start with the first image
        self.logo_label = ctk.CTkLabel(scrollable_frame)
        self.logo_label.pack(pady=10)

        # Load the first logo image
        self.update_logo()

        # Start the slideshow
        self.after(3000, self.slideshow)  # Change image every 3 seconds




        ctk.CTkButton(scrollable_frame, text="Lihat Biodata", command=lambda: controller.show_frame("SViewProfileFrame"), width=250).pack(pady=10)

        ctk.CTkButton(scrollable_frame, text="Edit Biodata", command=lambda: controller.show_frame("SEditProfileFrame"), width=250).pack(pady=10)
        
        ctk.CTkButton(scrollable_frame, text="Daftar Listingan Anda", command=lambda: controller.show_frame("SPropertyListFrame"), width=250).pack(pady=10)

        ctk.CTkButton(scrollable_frame, text="Hapus Listingan Anda", command=lambda: controller.show_frame("SEditPropertyFrame"), width=250).pack(pady=10)
        
        
        ctk.CTkButton(scrollable_frame, text="Ajukan Listingan Baru", command=lambda: controller.show_frame("SAddPropertyFrame"), width=250).pack(pady=10)
        
        ctk.CTkButton(scrollable_frame, text="Log Out", command=lambda: controller.show_frame("SLogoutFrame"), width=150).pack(pady=25)









        self.footer_frame = ctk.CTkFrame(self)
        self.footer_frame.pack(side='bottom', fill='x', padx=(10, 10), pady=(10, 10))

        # Add copyright label
        copyright_label = ctk.CTkLabel(self.footer_frame, text="Copyright © 2025 NNG Property by nayrbryanGaming Official. All rights reserved.", font=("Arial", 10))
        copyright_label.pack(side='top', pady=(0, 5))  # Place at the top of the footer

        # Add social media links
        self.add_social_media_links()

    def add_social_media_links(self):
        """Load and display social media links."""
        social_media = {
            "Website": "https://nayrbryangaming.wixsite.com/nng-store",
            "TikTok": "https://www.tiktok.com/@nng_store?_t=8sdywlIzjIg&_r=1",
            "Facebook": "https://www.facebook.com/profile.php?id=61567061512465",
            "Instagram": "https://www.instagram.com/nngstoreofficial/profilecard/?igsh=cjI5eWFxMGFnd2Jz",
            "YouTube": "https://www.youtube.com/@NNGStore",
            # Add more platforms as needed
        }

        social_media_frame = ctk.CTkFrame(self.footer_frame)  # Create a frame for social media links
        social_media_frame.pack(side='top')  # Pack it below the copyright label

        for platform, url in social_media.items():
            link_label = ctk.CTkLabel(social_media_frame, text=platform, font=("Arial", 10), text_color="White", cursor="hand2")
            link_label.pack(side='left', padx=(5, 5))
            link_label.bind("<Button-1>", lambda e, url=url: webbrowser.open(url))  # Bind click event to open URL












    def update_logo(self):
        """Load and display the current logo image with error handling."""
        logo_path = self.logo_images[self.current_image_index]

        try:
            # Check if the file exists before trying to open it
            if not os.path.exists(logo_path):
                raise FileNotFoundError(f"File not found: {logo_path}")
            
            logo_image = Image.open(logo_path)
            logo_image = logo_image.resize((300, 300), Image.LANCZOS)  # Resize if needed
            self.logo_photo = ImageTk.PhotoImage(logo_image)

            # Update the label with the new image
            self.logo_label.configure(image=self.logo_photo)

        except Exception as e:
            print(f"Error loading image: {e}")
            # Optionally set a default image or handle the error accordingly

        
    def slideshow(self):
        """Change to the next logo image in the slideshow."""
        # Update index to show next image
        self.current_image_index = (self.current_image_index + 1) % len(self.logo_images)
        
        # Update the logo displayed in the label
        self.update_logo()
        
        # Schedule the next slideshow update
        self.after(3000, self.slideshow)  # Change image every 3 seconds














class SViewProfileFrame(ctk.CTkFrame):
    def __init__(self, parent, controller):
        super().__init__(parent)
        self.controller = controller

        # Create a scrollable frame
        scrollable_frame = ctk.CTkScrollableFrame(self)
        scrollable_frame.pack(expand=True, fill="both", padx=20, pady=20)

        ctk.CTkLabel(scrollable_frame, text="Biodata Lengkap Anda", font=("Arial", 24)).pack(pady=20)

        profile_image_path = r"C:\\Users\\arche\\0(python VISUAL STUDIO CODE)\\Property\\me.jpg"  # Update with your actual image path
        self.profile_image = self.create_circular_image(profile_image_path, size=(500, 500))

        # Display profile image
        self.profile_photo = ImageTk.PhotoImage(self.profile_image)
        profile_label = ctk.CTkLabel(scrollable_frame, image=self.profile_photo)
        profile_label.pack(pady=10)




        # Dummy profile information for demonstration
        profile_info = {
            "Nama Panggilan": "Vin",
            "Nama Lengkap": "Vincentius Bryan Kwandou",
            "NIK": "7371091708000009",
            "Tempat Lahir": "Jayapura",
            "Tanggal Lahir": "17/08/2000",
            "Status Kewarganegaraan": "WNI",
            "Jenis Kelamin": "Pria",
            "Status Perkawinan": "Belum Menikah",
            "Golongan Darah": "O",
            "Rhesus": "Positif",
            "Pekerjaan": "Konten Kreator TikTok",
            "Lama Bekerja": "Lebih Dari 10 Tahun",
            "Alamat Tempat Kerja": "Jl. Urip No.5",
            "Alamat": "Jl. Urip No.5",
            "Nomor Telepon": "082293212721",
            "Penghasilan Per Bulan": "Rp 6.000.000",
            "Status BI Checking": "Kolektibilitas 1",
            "Jumlah Tabungan Saat Ini": "< Rp 50.000.000,-"
        }

        # Add each profile information label to the scrollable frame
        for label_text, info in profile_info.items():
            entry_frame = ctk.CTkFrame(scrollable_frame)
            entry_frame.pack(fill='x', pady=5)

            label = ctk.CTkLabel(entry_frame, text=f"{label_text}: {info}", font=("Arial", 10), anchor='w')
            label.pack(side='left', padx=(0, 10), fill='x')

        ctk.CTkButton(self, text="Kembali ke Dashboard", command=lambda: controller.show_frame("SalesDashboardFrame")).pack(pady=20)



    def create_circular_image(self, path, size=(700, 700)):
        """Create a circular image from a given path."""
        img = Image.open(path).convert("RGBA")
        img = img.resize(size, Image.LANCZOS)

        # Create a circular mask
        mask = Image.new("L", size, 0)
        draw = ImageDraw.Draw(mask)
        draw.ellipse((0, 0) + size, fill=255)

        # Apply mask to the image
        circular_img = Image.new("RGBA", size)
        circular_img.paste(img, (0, 0), mask)

        return circular_img




        


























class SEditProfileFrame(ctk.CTkFrame):
    def __init__(self, parent, controller):
        super().__init__(parent)
        self.controller = controller

        scrollable_frame = ctk.CTkScrollableFrame(self)
        scrollable_frame.pack(expand=True, fill="both", padx=20, pady=20)

        ctk.CTkLabel(scrollable_frame, text="Edit Profile", font=("Arial", 24)).pack(pady=20)

 
        # Entry fields for profile details
        self.name_entry = ctk.CTkEntry(scrollable_frame, placeholder_text="Nama Lengkap")
        self.name_entry.pack(pady=10)

        self.email_entry = ctk.CTkEntry(scrollable_frame, placeholder_text="Email")
        self.email_entry.pack(pady=10)

        self.phone_entry = ctk.CTkEntry(scrollable_frame, placeholder_text="Nomor Telepon")
        self.phone_entry.pack(pady=10)

         # Date of Birth using tkcalendar DateEntry
        ctk.CTkLabel(scrollable_frame, text="Tanggal Lahir").pack(pady=(0))
        self.dob_entry = DateEntry(scrollable_frame, width=30)
        self.dob_entry.pack(pady=0)


# Dropdowns with labels for other attributes
        nationality_options = ["WNI", "WNA", "Kewarganegaraan Ganda", "Tanpa Kewarganegaraan"]
        gender_options = ["Pria", "Wanita"]
        marital_status_options = ["Belum Menikah", "Sudah Menikah"]
        blood_type_options = ["A", "B", "AB", "O"]
        rhesus_options = ["Positif", "Negatif"]
        work_duration_options = ["Kurang dari 1 Tahun", "1-3 Tahun", "3-5 Tahun", "5-10 Tahun", "Lebih Dari 10 Tahun"]
        income_options = ["<Rp 3.000.000", "Rp 3.000.000 - Rp 5.999.999", "Rp 6.000.000 - Rp 9.999.999", "Rp 10.000.000 - Rp 19.999.999", "Rp 20.000.000 - Rp 34.999.999" , "Rp 35.000.000 - Rp 50.000.000","> Rp 60.000.000"]
        bi_status_options = ["Kolektibilitas 1", "Kolektibilitas 2", "Kolektibilitas 3", "Kolektibilitas 4", "Kolektibilitas 5"]
        savings_options = ["< Rp 50.000.000", "Rp 50.000.000 - Rp 99.999.999","Rp 100.000.000 - Rp 499.999.999", "Rp 500.000.000 - Rp 999.999.999", "Rp 1.000.000.000 - Rp 10.000.000.000", "> Rp 10.000.000.000"]

         # Dropdowns with corresponding labels
        ctk.CTkLabel(scrollable_frame, text="Kewarganegaraan").pack(pady=(0))
        ctk.CTkOptionMenu(scrollable_frame, values=nationality_options).pack(pady=(5))

        ctk.CTkLabel(scrollable_frame, text="Jenis Kelamin").pack(pady=(0))
        ctk.CTkOptionMenu(scrollable_frame, values=gender_options).pack(pady=(5))

        ctk.CTkLabel(scrollable_frame, text="Status Perkawinan").pack(pady=(0))
        ctk.CTkOptionMenu(scrollable_frame, values=marital_status_options).pack(pady=(5))

        ctk.CTkLabel(scrollable_frame, text="Golongan Darah").pack(pady=(0))
        ctk.CTkOptionMenu(scrollable_frame, values=blood_type_options).pack(pady=(5))

        ctk.CTkLabel(scrollable_frame, text="Rhesus").pack(pady=(0))
        ctk.CTkOptionMenu(scrollable_frame, values=rhesus_options).pack(pady=(5))

        ctk.CTkLabel(scrollable_frame, text="Lama Bekerja").pack(pady=(0))
        ctk.CTkOptionMenu(scrollable_frame, values=work_duration_options).pack(pady=(5))

        ctk.CTkLabel(scrollable_frame, text="Penghasilan Per Bulan").pack(pady=(0))
        ctk.CTkOptionMenu(scrollable_frame, values=income_options).pack(pady=(5))

        ctk.CTkLabel(scrollable_frame, text="Status BI Checking").pack(pady=(0))
        ctk.CTkOptionMenu(scrollable_frame, values=bi_status_options).pack(pady=(5))

        ctk.CTkLabel(scrollable_frame, text="Jumlah Tabungan Saat Ini").pack(pady=(0))
        ctk.CTkOptionMenu(scrollable_frame, values=savings_options).pack(pady=(5))


        ctk.CTkButton(self, text="Simpan Perubahan", command=self.save_changes).pack(pady=40)

    def save_changes(self):
        full_name = self.name_entry.get()
        email = self.email_entry.get()
        phone_number = self.phone_entry.get()

        print(f"Profile Updated: Name: {full_name}, Email: {email}, Phone: {phone_number}")

         # Clear entry fields after saving.
        self.name_entry.delete(0, 'end')
        self.email_entry.delete(0, 'end')
        self.phone_entry.delete(0, 'end')

         # Optionally navigate back to the dashboard.
        self.controller.show_frame("SalesDashboardFrame")































# Frame Property List
class SPropertyListFrame(ctk.CTkFrame):
    def __init__(self, parent, controller):
        super().__init__(parent)
        self.controller = controller

        ctk.CTkLabel(self, text="Properti yang sudah anda daftarkan", font=("Arial", 24)).pack(pady=20)

        scrollable_frame = ctk.CTkScrollableFrame(self)
        scrollable_frame.pack(expand=True, fill="both", padx=20, pady=20)

        # Dummy property list with details
        properties = [
            {
                "Nama": "CitraLand City CPI Makassar - Golden Avenue",
                "Harga": "Mulai Rp 5.000.000.000",
                "Lokasi": "Mariso, Makassar",
                "Deskripsi": "Rumah 2 lantai dengan desain modern, luas bangunan 166 m², dan luas tanah 162 m²",
                "Detail Rumah": "3+1 kamar tidur, 4 kamar mandi, garasi untuk 1 mobil, daya listrik 3300 Watt, sumber air PAM, dan fitur smart home.",
                "Developer": "Ciputra",
                "Bank yang Bekerjasama": "BCA",
                "Image Path": r"C:\\Users\\arche\\0(python VISUAL STUDIO CODE)\\Property\\1.jpg"
            },





            {
                "Nama": "Summarecon Mutiara Makassar - Cluster Akasia",
                "Harga": "Mulai Rp 1.100.000.000 hingga Rp 2.100.000.000",
                "Lokasi": "Summarecon Mutiara Makassar, Biring Kanaya, Makassar",
                "Deskripsi": "Perumahan dengan konsep Aeroport City, dikembangkan di atas lahan seluas 400 hektar, dekat dengan bandara dan pelabuhan baru, serta memiliki akses tol langsung.",
                "Detail Rumah": "Beragam tipe rumah dengan fasilitas kolam renang, area bermain, ruang komunitas, lapangan basket, taman hijau, keamanan 24 jam, dan sekolah.",
                "Developer": "Summarecon",
                "Bank yang Bekerjasama": "BCA",
                "Image Path": r"C:\\Users\\arche\\0(python VISUAL STUDIO CODE)\\Property\\2.jpg"
            
            },
            {
                "Nama": "Summarecon Mutiara Makassar - Jade Residence",
                "Harga": "Mulai Rp 1.100.000.000",
                "Lokasi": "Summarecon Mutiara Makassar, Biring Kanaya, Makassar",
                "Deskripsi": "Hunian mewah dengan sentuhan gaya klasik yang mewakili kemapanan dan keanggunan dengan detail arsitektur yang kaya.",
                "Detail Rumah": "Beragam tipe rumah dengan fasilitas kolam renang, area bermain, ruang komunitas, lapangan basket, taman hijau, keamanan 24 jam, dan sekolah.",
                "Developer": "Summarecon",
                "Bank yang Bekerjasama": "BCA",
                "Image Path": r"C:\\Users\\arche\\0(python VISUAL STUDIO CODE)\\Property\\3.jpg"
            },
            {
                "Nama": "Summarecon Mutiara Makassar - Jade 2 Residence",
                "Harga": "Mulai Rp 2,2 miliar (termasuk PPN dan BPHTB)",
                "Lokasi": "Summarecon Mutiara Makassar,Biring Kanaya, Makassar",
                "Deskripsi": "Properti dengan desain modern klasik, menawarkan kenyamanan dan kemewahan bagi penghuninya.",
                "Detail Rumah": "-",
                "Developer": "Summarecon",
                "Bank yang Bekerjasama": "BCA",
                "Image Path": r"C:\Users\arche\0(python VISUAL STUDIO CODE)\Property\4.jpg"
            },
            {
                "Nama": "Summarecon Mutiara Makassar - The Topaz Residence",
                "Harga": "Mulai Rp 2,1 miliar (termasuk PPN dan BPHTB)",
                "Lokasi": "Summarecon Mutiara Makassar,Biring Kanaya, Makassar",
                "Deskripsi": "Cluster dengan desain modern, menawarkan kenyamanan bagi penghuninya.",
                "Detail Rumah": "-",
                "Developer": "Summarecon",
                "Bank yang Bekerjasama": "BCA",
                "Image Path": r"C:\Users\arche\0(python VISUAL STUDIO CODE)\Property\5.jpg"
            },
            {
                "Nama": "Summarecon Mutiara Makassar - The Topaz Residence Type Sherry",
                "Harga": "Mulai Rp 2,5 miliar (termasuk PPN dan BPHTB)",
                "Lokasi": "Summarecon Mutiara Makassar,Biring Kanaya, Makassar",
                "Deskripsi": "Hunian dengan desain modern yang memukau, menggabungkan elegansi dan kenyamanan.",
                "Detail Rumah": "-",
                "Developer": "Summarecon",
                "Bank yang Bekerjasama": "BCA",
                "Image Path": r"C:\Users\arche\0(python VISUAL STUDIO CODE)\Property\6.jpg"
            },
            {
                "Nama": "Summarecon Mutiara Makassar - Beryl Residence",
                "Harga": "Mulai Rp 1,2 miliar (termasuk PPN dan BPHTB)",
                "Lokasi": "Summarecon Mutiara Makassar,Biring Kanaya, Makassar",
                "Deskripsi": "Cluster dengan fasilitas umum seperti kolam renang, clubhouse, dan area bermain anak.",
                "Detail Rumah": "-",
                "Developer": "Summarecon",
                "Bank yang Bekerjasama": "BCA",
                "Image Path": r"C:\Users\arche\0(python VISUAL STUDIO CODE)\Property\7.jpg"
            },
            {
                "Nama": "Summarecon Mutiara Makassar - Blue Crystal",
                "Harga": "Mulai Rp 2 miliar (termasuk PPN dan BPHTB)",
                "Lokasi": "Summarecon Mutiara Makassar,Biring Kanaya, Makassar",
                "Deskripsi": "Cluster dengan desain tropis kontemporer, dilengkapi fasilitas umum yang mendukung kenyamanan penghuni.",
                "Detail Rumah": "-",
                "Developer": "Summarecon",
                "Bank yang Bekerjasama": "BCA",
                "Image Path": r"C:\Users\arche\0(python VISUAL STUDIO CODE)\Property\8.jpg"
            },
            {
                "Nama": "Summarecon Mutiara Makassar - Green Crystal",
                "Harga": "Mulai Rp 2 miliar (termasuk PPN dan BPHTB)",
                "Lokasi": "Summarecon Mutiara Makassar,Biring Kanaya, Makassar",
                "Deskripsi": "Cluster dengan fasilitas modern, menawarkan kenyamanan dan kemewahan bagi penghuninya.",
                "Detail Rumah": "-",
                "Developer": "Summarecon",
                "Bank yang Bekerjasama": "BCA",
                "Image Path": r"C:\Users\arche\0(python VISUAL STUDIO CODE)\Property\9.jpg"
            },
            {
                "Nama": "Summarecon Mutiara Makassar - The Morizen Makassar",
                "Harga": "Mulai Rp 10 miliar (termasuk PPN dan BPHTB)",
                "Lokasi": "Summarecon Mutiara Makassar,Biring Kanaya, Makassar",
                "Deskripsi": "Hunian dengan konsep Jepang, menawarkan keseimbangan antara elegansi dan kenyamanan.",
                "Detail Rumah": "-",
                "Developer": "Summarecon",
                "Bank yang Bekerjasama": "BCA",
                "Image Path": r"C:\Users\arche\0(python VISUAL STUDIO CODE)\Property\10.jpg"
            },
            {
                "Nama": "Summarecon Mutiara Makassar - Ruko Graha Boulevard Makassar",
                "Harga": "Mulai Rp 1,5 miliar (termasuk PPN dan BPHTB)",
                "Lokasi": "Summarecon Mutiara Makassar,Biring Kanaya, Makassar",
                "Deskripsi": "Ruko 3 lantai dengan lokasi strategis, cocok untuk berbagai jenis usaha. ",
                "Detail Rumah": "Luas bangunan 115 m², 1 kamar mandi",
                "Developer": "Summarecon",
                "Bank yang Bekerjasama": "BCA",
                "Image Path": r"C:\Users\arche\0(python VISUAL STUDIO CODE)\Property\11.jpg"
            },






            {
                "Nama": "Virginia Park Makassar",
                "Harga": "Mulai Rp 1.000.000.000 hingga Rp 2.000.000.000",
                "Lokasi": "Biring Kanaya, Makassar",
                "Deskripsi": "Perumahan mewah dengan konsep Luxury Home with Green Development Concept, menawarkan hunian mewah dengan lingkungan hijau yang nyaman.",
                "Detail Rumah": "-",
                "Developer": "Brighton Real Estate",
                "Bank yang Bekerjasama": "-",
                "Image Path": r"C:\Users\arche\0(python VISUAL STUDIO CODE)\Property\12.jpg"
            },
             {
                "Nama": "Perumahan Grand Barombong",
                "Harga": "Rp 177.000.000",
                "Lokasi": "Makassar",
                "Deskripsi": "Rumah tinggal 1 lantai dengan lokasi strategis dan harga terjangkau.",
                "Detail Rumah": "Luas tanah 72 m², luas bangunan 36 m².",
                "Developer": "-",
                "Bank yang Bekerjasama": "-",
                "Image Path": r"C:\Users\arche\0(python VISUAL STUDIO CODE)\Property\13.jpg"
            },
             {
                "Nama": "Royal Sentraland BTP Makassar",
                "Harga": "Rp 330.000.000",
                "Lokasi": "Makassar",
                "Deskripsi": "Rumah tinggal 2 lantai dengan 3 kamar tidur dan 3 kamar mandi.",
                "Detail Rumah": "Luas tanah 84 m², luas bangunan 84 m².",
                "Developer": "-",
                "Bank yang Bekerjasama": "-",
                "Image Path": r"C:\Users\arche\0(python VISUAL STUDIO CODE)\Property\14.jpg"
            },
            {
                "Nama": "Rumah Tengah Kota Makassar",
                "Harga": "Mulai Rp 588.000.000",
                "Lokasi": "Makassar",
                "Deskripsi": "Rumah tersedia dalam 2 tipe, 1 dan 2 lantai, dengan opsi cicilan developer maksimal 3 tahun tanpa bank dan tanpa bunga.",
                "Detail Rumah": "-",
                "Developer": "Rajata",
                "Bank yang Bekerjasama": "-",
                "Image Path": r"C:\Users\arche\0(python VISUAL STUDIO CODE)\Property\15.jpg"
            },
             {
                "Nama": "Perumahan Green Residence Sudiang",
                "Harga": "Mulai Rp 700.000.000",
                "Lokasi": "Sudiang, Makassar",
                "Deskripsi": " Kawasan ramah lingkungan dengan fasilitas taman hijau dan sistem cluster.",
                "Detail Rumah": "Rumah 1 lantai, 2 kamar tidur, 1 kamar mandi, luas tanah 72 m².",
                "Developer": "GreenLand Developer",
                "Bank yang Bekerjasama": "Bank Mandiri, BNI",
                "Image Path": r"C:\Users\arche\0(python VISUAL STUDIO CODE)\Property\16.jpg"
            },
            {
                "Nama": "Perumahan Taman Sari Makassar",
                "Harga": "Mulai Rp 1.200.000.000",
                "Lokasi": "Tamalanrea, Makassar",
                "Deskripsi": "Perumahan dengan konsep modern minimalis, dilengkapi dengan fasilitas keamanan 24 jam dan taman bermain anak.",
                "Detail Rumah": "Rumah 2 lantai, 3 kamar tidur, 2 kamar mandi, luas tanah 90 m².",
                "Developer": "PT. Taman Sari Makassar",
                "Bank yang Bekerjasama": "BCA, BRI",
                "Image Path": r"C:\Users\arche\0(python VISUAL STUDIO CODE)\Property\17.jpg"
            },
             {
                "Nama": "Perumahan Bukit Baruga Antang",
                "Harga": "Mulai Rp 900.000.000",
                "Lokasi": "Antang, Makassar",
                "Deskripsi": "Perumahan dengan lingkungan asri,",
                "Detail Rumah": "-",
                "Developer": "Bukit Baruga",
                "Bank yang Bekerjasama": "BCA",
                "Image Path": r"C:\Users\arche\0(python VISUAL STUDIO CODE)\Property\18.jpg"
            },
             
            
        ]

        for property in properties:
            # Create a frame for each property
            property_frame = ctk.CTkFrame(scrollable_frame)
            property_frame.pack(fill='x', padx=5, pady=5)
            img_path = property.get("Image Path")
            # Load and display the property image
            img_path = property["Image Path"]
            if img_path:  # Check if img_path is not None
                img = Image.open(img_path)
                img = img.resize((400, 400), Image.LANCZOS)  # Resize as needed
                img_photo = ImageTk.PhotoImage(img)

        # Create labels for the image and text
                image_label = ctk.CTkLabel(property_frame, image=img_photo)
                image_label.image = img_photo  # Keep a reference to avoid garbage collection
                image_label.grid(row=0, column=0, padx=10)

            # Create a frame for text information
            text_frame = ctk.CTkFrame(property_frame)
            text_frame.grid(row=0, column=1, padx=10)

            # Add property details to the text frame
            ctk.CTkLabel(text_frame, text="Nama: ", font=("Arial", 14)).grid(row=0, column=0, sticky="w")
            ctk.CTkLabel(text_frame, text=property["Nama"], font=("Arial", 14)).grid(row=0, column=1, sticky="w")

            ctk.CTkLabel(text_frame, text="Harga: ", font=("Arial", 14)).grid(row=1, column=0, sticky="w")
            ctk.CTkLabel(text_frame, text=property["Harga"], font=("Arial", 14)).grid(row=1, column=1, sticky="w")

            ctk.CTkLabel(text_frame, text="Lokasi: ", font=("Arial", 14)).grid(row=2, column=0, sticky="w")
            ctk.CTkLabel(text_frame, text=property["Lokasi"], font=("Arial", 14)).grid(row=2, column=1, sticky="w")

            ctk.CTkLabel(text_frame, text="Deskripsi: ", font=("Arial", 14)).grid(row=3, column=0, sticky="w")
            ctk.CTkLabel(text_frame, text=property["Deskripsi"], font=("Arial", 12), text_color="gray").grid(row=3, column=1, sticky="w")

            ctk.CTkLabel(text_frame, text="Detail Rumah: ", font=("Arial", 14)).grid(row=4, column=0, sticky="w")
            ctk.CTkLabel(text_frame, text=property["Detail Rumah"], font=("Arial", 12), text_color="gray").grid(row=4, column=1, sticky="w")

            ctk.CTkLabel(text_frame, text="Developer: ", font=("Arial", 14)).grid(row=5, column=0, sticky="w")
            ctk.CTkLabel(text_frame, text=property["Developer"], font=("Arial", 12), text_color="gray").grid(row=5, column=1, sticky="w")

            ctk.CTkLabel(text_frame, text="Bank yang Bekerjasama: ", font=("Arial", 14)).grid(row=6, column=0, sticky="w")
            ctk.CTkLabel(text_frame, text=property["Bank yang Bekerjasama"], font=("Arial", 12), text_color="gray").grid(row=6, column=1, sticky="w")
        # Back button to return to the dashboard
        ctk.CTkButton(self,
                      text="Kembali ke Dashboard",
                      command=lambda: controller.show_frame("SalesDashboardFrame")).pack(pady=(10))
        































# Frame Add Property
class SAddPropertyFrame(ctk.CTkFrame):
    def __init__(self, parent, controller):
        super().__init__(parent)
        self.controller = controller

        ctk.CTkLabel(self, text="Tambah Properti Baru", font=("Arial", 24)).pack(pady=20)


        self.scrollable_frame = ctk.CTkScrollableFrame(self)
        self.scrollable_frame.pack(expand=True, fill="both", padx=20, pady=20)

        # Entry fields for new property details
        self.property_name_entry = ctk.CTkEntry(self.scrollable_frame, placeholder_text="Nama Properti")
        self.property_name_entry.pack(pady=10)

        self.property_price_entry = ctk.CTkEntry(self.scrollable_frame, placeholder_text="Harga")
        self.property_price_entry.pack(pady=10)

        self.property_location_entry = ctk.CTkEntry(self.scrollable_frame, placeholder_text="Lokasi")
        self.property_location_entry.pack(pady=10)

        self.property_address_entry = ctk.CTkEntry(self.scrollable_frame, placeholder_text="Alamat Lengkap")
        self.property_address_entry.pack(pady=10)


# Property type selection using radio buttons
        self.property_type_var = ctk.StringVar(value="Rumah Tinggal")  # Default value

        property_type_frame = ctk.CTkFrame(self.scrollable_frame)
        property_type_frame.pack(pady=10)

        ctk.CTkLabel(property_type_frame, text="Tipe Properti:").pack(anchor='w')

        # Radio buttons for property types
        property_types = ["Rumah Tinggal", "Ruko", "Apartemen"]
        
        for property_type in property_types:
            radio_button = ctk.CTkRadioButton(property_type_frame,
                                               text=property_type,
                                               variable=self.property_type_var,
                                               value=property_type)
            radio_button.pack(anchor='w')  # Align left


        
        # Entry for description
        self.property_description_entry = ctk.CTkEntry(self.scrollable_frame, placeholder_text="Deskripsi")
        self.property_description_entry.pack(pady=10)

        # Entry for house details
        self.phpouse_details_entry = ctk.CTkEntry(self.scrollable_frame, placeholder_text="Detail Isi Rumah")
        self.phpouse_details_entry.pack(pady=10)

        # Entry for developer
        self.developer_entry = ctk.CTkEntry(self.scrollable_frame, placeholder_text="Developer")
        self.developer_entry.pack(pady=10)

        # Entry for cooperating bank
        self.bank_entry = ctk.CTkEntry(self.scrollable_frame, placeholder_text="Bank yang Bekerjasama")
        self.bank_entry.pack(pady=10)

        # KPR option
        self.kpr_var = ctk.StringVar(value="Tidak")  # Default value
        kpr_frame = ctk.CTkFrame(self.scrollable_frame)
        kpr_frame.pack(pady=(10, 0))

        ctk.CTkLabel(kpr_frame, text="Mendukung KPR?").pack()
        
        kpr_yes_radio = ctk.CTkRadioButton(kpr_frame, text="Ya", variable=self.kpr_var, value="Ya")
        kpr_yes_radio.pack(side='left', padx=(10, 5))  # Align left with padding
        
        kpr_no_radio = ctk.CTkRadioButton(kpr_frame, text="Tidak", variable=self.kpr_var, value="Tidak")
        kpr_no_radio.pack(side='left', padx=(5, 10))  # Align left with padding

        # Cash option
        self.cash_var = ctk.StringVar(value="Tidak")  # Default value
        cash_frame = ctk.CTkFrame(self.scrollable_frame)
        cash_frame.pack(pady=(10, 0))

        ctk.CTkLabel(cash_frame, text="Apakah bisa Cash?").pack()
        
        cash_yes_radio = ctk.CTkRadioButton(cash_frame, text="Ya", variable=self.cash_var, value="Ya")
        cash_yes_radio.pack(side='left', padx=(10, 5))  # Align left with padding
        
        cash_no_radio = ctk.CTkRadioButton(cash_frame, text="Tidak", variable=self.cash_var, value="Tidak")
        cash_no_radio.pack(side='left', padx=(5, 10))  # Align left with padding

        # Button to upload an image
        self.upload_image_button = ctk.CTkButton(self.scrollable_frame, text="Unggah Gambar Detil Rumah", command=self.upload_image)
        self.upload_image_button.pack(pady=10)

        self.image_path_label = ctk.CTkLabel(self.scrollable_frame, text="Belum Ada Gambar Yang Dipilih", font=("Arial", 10))
        self.image_path_label.pack(pady=5)

        ctk.CTkButton(self, text="Ajukan Properti", command=self.add_property).pack(pady=20)

        # Variable to store the image path
        self.image_path = r"C:\Users\arche\0(python VISUAL STUDIO CODE)\Property"

    def upload_image(self):
        """Open a file dialog to select an image and update the label."""
        self.image_path = filedialog.askopenfilename(title="Select an Image",
                                                      filetypes=[("Image Files", "*.jpg;*.jpeg;*.png")])
        if self.image_path:
            self.image_path_label.configure(text=self.image_path.split("/")[-1])  # Display only the file name

    def add_property(self):
        """Logic to add the property would go here."""
        property_name = self.property_name_entry.get()
        property_price = self.property_price_entry.get()
        property_location = self.property_location_entry.get()

        print(f"Added Property: {property_name}, Price: {property_price}, Location: {property_location}, Image Path: {self.image_path}")

        # Clear entry fields after adding.
        self.property_name_entry.delete(0, 'end')
        self.property_price_entry.delete(0, 'end')
        self.property_location_entry.delete(0, 'end')
        
        # Optionally navigate back to the dashboard or show a success message.
        self.controller.show_frame("SalesDashboardFrame")












class SPropertyListFrame(ctk.CTkFrame):
    def __init__(self, parent, controller):
        super().__init__(parent)
        self.controller = controller

        
        ctk.CTkLabel(self, text="Properti yang anda sudah daftarkan", font=("Arial", 24)).pack(pady=20)

        scrollable_frame = ctk.CTkScrollableFrame(self)
        scrollable_frame.pack(expand=True, fill="both", padx=20, pady=20)

        # Dummy property list with details
        properties = [
            {
                "Nama": "CitraLand City CPI Makassar - Golden Avenue",
                "Harga": "Mulai Rp 5.000.000.000",
                "Lokasi": "Mariso, Makassar",
                "Deskripsi": "Rumah 2 lantai dengan desain modern, luas bangunan 166 m², dan luas tanah 162 m²",
                "Detail Rumah": "3+1 kamar tidur, 4 kamar mandi, garasi untuk 1 mobil, daya listrik 3300 Watt, sumber air PAM, dan fitur smart home.",
                "Developer": "Ciputra",
                "Bank yang Bekerjasama": "BCA",
                "Image Path": r"C:\\Users\\arche\\0(python VISUAL STUDIO CODE)\\Property\\1.jpg"
            },





            {
                "Nama": "Summarecon Mutiara Makassar - Cluster Akasia",
                "Harga": "Mulai Rp 1.100.000.000 hingga Rp 2.100.000.000",
                "Lokasi": "Summarecon Mutiara Makassar, Biring Kanaya, Makassar",
                "Deskripsi": "Perumahan dengan konsep Aeroport City, dikembangkan di atas lahan seluas 400 hektar, dekat dengan bandara dan pelabuhan baru, serta memiliki akses tol langsung.",
                "Detail Rumah": "Beragam tipe rumah dengan fasilitas kolam renang, area bermain, ruang komunitas, lapangan basket, taman hijau, keamanan 24 jam, dan sekolah.",
                "Developer": "Summarecon",
                "Bank yang Bekerjasama": "BCA",
                "Image Path": r"C:\\Users\\arche\\0(python VISUAL STUDIO CODE)\\Property\\2.jpg"
            
            },
            {
                "Nama": "Summarecon Mutiara Makassar - Jade Residence",
                "Harga": "Mulai Rp 1.100.000.000",
                "Lokasi": "Summarecon Mutiara Makassar, Biring Kanaya, Makassar",
                "Deskripsi": "Hunian mewah dengan sentuhan gaya klasik yang mewakili kemapanan dan keanggunan dengan detail arsitektur yang kaya.",
                "Detail Rumah": "Beragam tipe rumah dengan fasilitas kolam renang, area bermain, ruang komunitas, lapangan basket, taman hijau, keamanan 24 jam, dan sekolah.",
                "Developer": "Summarecon",
                "Bank yang Bekerjasama": "BCA",
                "Image Path": r"C:\\Users\\arche\\0(python VISUAL STUDIO CODE)\\Property\\3.jpg"
            },
            {
                "Nama": "Summarecon Mutiara Makassar - Jade 2 Residence",
                "Harga": "Mulai Rp 2,2 miliar (termasuk PPN dan BPHTB)",
                "Lokasi": "Summarecon Mutiara Makassar,Biring Kanaya, Makassar",
                "Deskripsi": "Properti dengan desain modern klasik, menawarkan kenyamanan dan kemewahan bagi penghuninya.",
                "Detail Rumah": "-",
                "Developer": "Summarecon",
                "Bank yang Bekerjasama": "BCA",
                "Image Path": r"C:\Users\arche\0(python VISUAL STUDIO CODE)\Property\4.jpg"
            },
            {
                "Nama": "Summarecon Mutiara Makassar - The Topaz Residence",
                "Harga": "Mulai Rp 2,1 miliar (termasuk PPN dan BPHTB)",
                "Lokasi": "Summarecon Mutiara Makassar,Biring Kanaya, Makassar",
                "Deskripsi": "Cluster dengan desain modern, menawarkan kenyamanan bagi penghuninya.",
                "Detail Rumah": "-",
                "Developer": "Summarecon",
                "Bank yang Bekerjasama": "BCA",
                "Image Path": r"C:\Users\arche\0(python VISUAL STUDIO CODE)\Property\5.jpg"
            },
            {
                "Nama": "Summarecon Mutiara Makassar - The Topaz Residence Type Sherry",
                "Harga": "Mulai Rp 2,5 miliar (termasuk PPN dan BPHTB)",
                "Lokasi": "Summarecon Mutiara Makassar,Biring Kanaya, Makassar",
                "Deskripsi": "Hunian dengan desain modern yang memukau, menggabungkan elegansi dan kenyamanan.",
                "Detail Rumah": "-",
                "Developer": "Summarecon",
                "Bank yang Bekerjasama": "BCA",
                "Image Path": r"C:\Users\arche\0(python VISUAL STUDIO CODE)\Property\6.jpg"
            },
            {
                "Nama": "Summarecon Mutiara Makassar - Beryl Residence",
                "Harga": "Mulai Rp 1,2 miliar (termasuk PPN dan BPHTB)",
                "Lokasi": "Summarecon Mutiara Makassar,Biring Kanaya, Makassar",
                "Deskripsi": "Cluster dengan fasilitas umum seperti kolam renang, clubhouse, dan area bermain anak.",
                "Detail Rumah": "-",
                "Developer": "Summarecon",
                "Bank yang Bekerjasama": "BCA",
                "Image Path": r"C:\Users\arche\0(python VISUAL STUDIO CODE)\Property\7.jpg"
            },
            {
                "Nama": "Summarecon Mutiara Makassar - Blue Crystal",
                "Harga": "Mulai Rp 2 miliar (termasuk PPN dan BPHTB)",
                "Lokasi": "Summarecon Mutiara Makassar,Biring Kanaya, Makassar",
                "Deskripsi": "Cluster dengan desain tropis kontemporer, dilengkapi fasilitas umum yang mendukung kenyamanan penghuni.",
                "Detail Rumah": "-",
                "Developer": "Summarecon",
                "Bank yang Bekerjasama": "BCA",
                "Image Path": r"C:\Users\arche\0(python VISUAL STUDIO CODE)\Property\8.jpg"
            },
            {
                "Nama": "Summarecon Mutiara Makassar - Green Crystal",
                "Harga": "Mulai Rp 2 miliar (termasuk PPN dan BPHTB)",
                "Lokasi": "Summarecon Mutiara Makassar,Biring Kanaya, Makassar",
                "Deskripsi": "Cluster dengan fasilitas modern, menawarkan kenyamanan dan kemewahan bagi penghuninya.",
                "Detail Rumah": "-",
                "Developer": "Summarecon",
                "Bank yang Bekerjasama": "BCA",
                "Image Path": r"C:\Users\arche\0(python VISUAL STUDIO CODE)\Property\9.jpg"
            },
            {
                "Nama": "Summarecon Mutiara Makassar - The Morizen Makassar",
                "Harga": "Mulai Rp 10 miliar (termasuk PPN dan BPHTB)",
                "Lokasi": "Summarecon Mutiara Makassar,Biring Kanaya, Makassar",
                "Deskripsi": "Hunian dengan konsep Jepang, menawarkan keseimbangan antara elegansi dan kenyamanan.",
                "Detail Rumah": "-",
                "Developer": "Summarecon",
                "Bank yang Bekerjasama": "BCA",
                "Image Path": r"C:\Users\arche\0(python VISUAL STUDIO CODE)\Property\10.jpg"
            },
            {
                "Nama": "Summarecon Mutiara Makassar - Ruko Graha Boulevard Makassar",
                "Harga": "Mulai Rp 1,5 miliar (termasuk PPN dan BPHTB)",
                "Lokasi": "Summarecon Mutiara Makassar,Biring Kanaya, Makassar",
                "Deskripsi": "Ruko 3 lantai dengan lokasi strategis, cocok untuk berbagai jenis usaha. ",
                "Detail Rumah": "Luas bangunan 115 m², 1 kamar mandi",
                "Developer": "Summarecon",
                "Bank yang Bekerjasama": "BCA",
                "Image Path": r"C:\Users\arche\0(python VISUAL STUDIO CODE)\Property\11.jpg"
            },






            {
                "Nama": "Virginia Park Makassar",
                "Harga": "Mulai Rp 1.000.000.000 hingga Rp 2.000.000.000",
                "Lokasi": "Biring Kanaya, Makassar",
                "Deskripsi": "Perumahan mewah dengan konsep Luxury Home with Green Development Concept, menawarkan hunian mewah dengan lingkungan hijau yang nyaman.",
                "Detail Rumah": "-",
                "Developer": "Brighton Real Estate",
                "Bank yang Bekerjasama": "-",
                "Image Path": r"C:\Users\arche\0(python VISUAL STUDIO CODE)\Property\12.jpg"
            },
             {
                "Nama": "Perumahan Grand Barombong",
                "Harga": "Rp 177.000.000",
                "Lokasi": "Makassar",
                "Deskripsi": "Rumah tinggal 1 lantai dengan lokasi strategis dan harga terjangkau.",
                "Detail Rumah": "Luas tanah 72 m², luas bangunan 36 m².",
                "Developer": "-",
                "Bank yang Bekerjasama": "-",
                "Image Path": r"C:\Users\arche\0(python VISUAL STUDIO CODE)\Property\13.jpg"
            },
             {
                "Nama": "Royal Sentraland BTP Makassar",
                "Harga": "Rp 330.000.000",
                "Lokasi": "Makassar",
                "Deskripsi": "Rumah tinggal 2 lantai dengan 3 kamar tidur dan 3 kamar mandi.",
                "Detail Rumah": "Luas tanah 84 m², luas bangunan 84 m².",
                "Developer": "-",
                "Bank yang Bekerjasama": "-",
                "Image Path": r"C:\Users\arche\0(python VISUAL STUDIO CODE)\Property\14.jpg"
            },
            {
                "Nama": "Rumah Tengah Kota Makassar",
                "Harga": "Mulai Rp 588.000.000",
                "Lokasi": "Makassar",
                "Deskripsi": "Rumah tersedia dalam 2 tipe, 1 dan 2 lantai, dengan opsi cicilan developer maksimal 3 tahun tanpa bank dan tanpa bunga.",
                "Detail Rumah": "-",
                "Developer": "Rajata",
                "Bank yang Bekerjasama": "-",
                "Image Path": r"C:\Users\arche\0(python VISUAL STUDIO CODE)\Property\15.jpg"
            },
             {
                "Nama": "Perumahan Green Residence Sudiang",
                "Harga": "Mulai Rp 700.000.000",
                "Lokasi": "Sudiang, Makassar",
                "Deskripsi": " Kawasan ramah lingkungan dengan fasilitas taman hijau dan sistem cluster.",
                "Detail Rumah": "Rumah 1 lantai, 2 kamar tidur, 1 kamar mandi, luas tanah 72 m².",
                "Developer": "GreenLand Developer",
                "Bank yang Bekerjasama": "Bank Mandiri, BNI",
                "Image Path": r"C:\Users\arche\0(python VISUAL STUDIO CODE)\Property\16.jpg"
            },
            {
                "Nama": "Perumahan Taman Sari Makassar",
                "Harga": "Mulai Rp 1.200.000.000",
                "Lokasi": "Tamalanrea, Makassar",
                "Deskripsi": "Perumahan dengan konsep modern minimalis, dilengkapi dengan fasilitas keamanan 24 jam dan taman bermain anak.",
                "Detail Rumah": "Rumah 2 lantai, 3 kamar tidur, 2 kamar mandi, luas tanah 90 m².",
                "Developer": "PT. Taman Sari Makassar",
                "Bank yang Bekerjasama": "BCA, BRI",
                "Image Path": r"C:\Users\arche\0(python VISUAL STUDIO CODE)\Property\17.jpg"
            },
             {
                "Nama": "Perumahan Bukit Baruga Antang",
                "Harga": "Mulai Rp 900.000.000",
                "Lokasi": "Antang, Makassar",
                "Deskripsi": "Perumahan dengan lingkungan asri,",
                "Detail Rumah": "-",
                "Developer": "Bukit Baruga",
                "Bank yang Bekerjasama": "BCA",
                "Image Path": r"C:\Users\arche\0(python VISUAL STUDIO CODE)\Property\18.jpg"
            },
             
            
        ]

        for property in properties:
            # Create a frame for each property
            property_frame = ctk.CTkFrame(scrollable_frame)
            property_frame.pack(fill='x', padx=5, pady=5)
            img_path = property.get("Image Path")
            # Load and display the property image
            img_path = property["Image Path"]
            if img_path:  # Check if img_path is not None
                img = Image.open(img_path)
                img = img.resize((400, 400), Image.LANCZOS)  # Resize as needed
                img_photo = ImageTk.PhotoImage(img)

        # Create labels for the image and text
                image_label = ctk.CTkLabel(property_frame, image=img_photo)
                image_label.image = img_photo  # Keep a reference to avoid garbage collection
                image_label.grid(row=0, column=0, padx=10)

            # Create a frame for text information
            text_frame = ctk.CTkFrame(property_frame)
            text_frame.grid(row=0, column=1, padx=10)

            # Add property details to the text frame
            ctk.CTkLabel(text_frame, text="Nama: ", font=("Arial", 14)).grid(row=0, column=0, sticky="w")
            ctk.CTkLabel(text_frame, text=property["Nama"], font=("Arial", 14)).grid(row=0, column=1, sticky="w")

            ctk.CTkLabel(text_frame, text="Harga: ", font=("Arial", 14)).grid(row=1, column=0, sticky="w")
            ctk.CTkLabel(text_frame, text=property["Harga"], font=("Arial", 14)).grid(row=1, column=1, sticky="w")

            ctk.CTkLabel(text_frame, text="Lokasi: ", font=("Arial", 14)).grid(row=2, column=0, sticky="w")
            ctk.CTkLabel(text_frame, text=property["Lokasi"], font=("Arial", 14)).grid(row=2, column=1, sticky="w")

            ctk.CTkLabel(text_frame, text="Deskripsi: ", font=("Arial", 14)).grid(row=3, column=0, sticky="w")
            ctk.CTkLabel(text_frame, text=property["Deskripsi"], font=("Arial", 12), text_color="gray").grid(row=3, column=1, sticky="w")

            ctk.CTkLabel(text_frame, text="Detail Rumah: ", font=("Arial", 14)).grid(row=4, column=0, sticky="w")
            ctk.CTkLabel(text_frame, text=property["Detail Rumah"], font=("Arial", 12), text_color="gray").grid(row=4, column=1, sticky="w")

            ctk.CTkLabel(text_frame, text="Developer: ", font=("Arial", 14)).grid(row=5, column=0, sticky="w")
            ctk.CTkLabel(text_frame, text=property["Developer"], font=("Arial", 12), text_color="gray").grid(row=5, column=1, sticky="w")

            ctk.CTkLabel(text_frame, text="Bank yang Bekerjasama: ", font=("Arial", 14)).grid(row=6, column=0, sticky="w")
            ctk.CTkLabel(text_frame, text=property["Bank yang Bekerjasama"], font=("Arial", 12), text_color="gray").grid(row=6, column=1, sticky="w")
        # Back button to return to the dashboard
         # Back button to return to the dashboard
        ctk.CTkButton(self, text="Kembali ke Dashboard", command=lambda: controller.show_frame("SalesDashboardFrame")).pack(pady=10)
















# Frame Logout
class SLogoutFrame(ctk.CTkFrame):
    def __init__(self, parent, controller):
        super().__init__(parent)
        self.controller = controller

        ctk.CTkLabel(self, text="Anda telah berhasil keluar dari akun anda", font=("Arial", 24)).pack(pady=20)
        
        ctk.CTkButton(self, text="Login Kembali", command=lambda: controller.show_frame("LoginFrame")).pack(pady=10)








































































class BuyerDashboardFrame(ctk.CTkFrame):
    def __init__(self, parent, controller):
        super().__init__(parent)
        self.controller = controller

        ctk.CTkLabel(self, text="Selamat Datang Di Dashboard User", font=("Arial", 24)).pack(pady=0)


        scrollable_frame = ctk.CTkScrollableFrame(self)
        scrollable_frame.pack(expand=True, fill="both", padx=0, pady=0)


        self.logo_images = [
            r"C:\\Users\\arche\\0(python VISUAL STUDIO CODE)\\Property\\1.jpg",
            r"C:\\Users\\arche\\0(python VISUAL STUDIO CODE)\\Property\\2.jpg",
            r"C:\\Users\\arche\\0(python VISUAL STUDIO CODE)\\Property\\3.jpg",
            r"C:\\Users\\arche\\0(python VISUAL STUDIO CODE)\\Property\\4.jpg",
            r"C:\\Users\\arche\\0(python VISUAL STUDIO CODE)\\Property\\5.jpg",
            r"C:\\Users\\arche\\0(python VISUAL STUDIO CODE)\\Property\\6.jpg",
            r"C:\\Users\\arche\\0(python VISUAL STUDIO CODE)\\Property\\7.jpg",
            r"C:\\Users\\arche\\0(python VISUAL STUDIO CODE)\\Property\\8.jpg",
            r"C:\\Users\\arche\\0(python VISUAL STUDIO CODE)\\Property\\9.jpg",
            r"C:\\Users\\arche\\0(python VISUAL STUDIO CODE)\\Property\\10.jpg",
            r"C:\\Users\\arche\\0(python VISUAL STUDIO CODE)\\Property\\11.jpg",
            r"C:\\Users\\arche\\0(python VISUAL STUDIO CODE)\\Property\\12.jpg",
            r"C:\\Users\\arche\\0(python VISUAL STUDIO CODE)\\Property\\13.jpg"
        ]
        
        self.current_image_index = 0  # Start with the first image
        self.logo_label = ctk.CTkLabel(scrollable_frame)
        self.logo_label.pack(pady=10)

        # Load the first logo image
        self.update_logo()

        # Start the slideshow
        self.after(3000, self.slideshow)  # Change image every 3 seconds




        ctk.CTkButton(scrollable_frame, text="Biodata User", command=lambda: controller.show_frame("BViewProfileFrame"), width=250).pack(pady=10)

        ctk.CTkButton(scrollable_frame, text="Edit Biodata", command=lambda: controller.show_frame("BEditProfileFrame"), width=250).pack(pady=10)

        ctk.CTkButton(scrollable_frame, text="Daftar Properti Yang Tersedia", command=lambda: controller.show_frame("BPropertyListFrame"), width=250).pack(pady=10)
        
        ctk.CTkButton(scrollable_frame, text="Ajukan Pembelian Rumah", command=lambda: controller.show_frame("BAddPropertyFrame"), width=250).pack(pady=10)

        ctk.CTkButton(scrollable_frame, text="Laporkan Properti yang Bermasalah", command=lambda: controller.show_frame("BEditPropertyFrame"), width=250).pack(pady=10)
        
        ctk.CTkButton(scrollable_frame, text="Hubungi Sales", command=lambda: controller.show_frame("ContactSalesFrame"), width=250).pack(pady=10)

        ctk.CTkButton(scrollable_frame, text="FAQ Chatbot", command=lambda: controller.show_frame("ChatbotFrame"), width=250).pack(pady=10)


        ctk.CTkButton(scrollable_frame, text="Log Out", command=lambda: controller.show_frame("BLogoutFrame"), width=150).pack(pady=25)







        self.footer_frame = ctk.CTkFrame(self)
        self.footer_frame.pack(side='bottom', fill='x', padx=(10, 10), pady=(10, 10))

        # Add copyright label
        copyright_label = ctk.CTkLabel(self.footer_frame, text="Copyright © 2025 NNG Property by nayrbryanGaming Official. All rights reserved.", font=("Arial", 10))
        copyright_label.pack(side='top', pady=(0, 5))  # Place at the top of the footer

        # Add social media links
        self.add_social_media_links()

    def add_social_media_links(self):
        """Load and display social media links."""
        social_media = {
            "Website": "https://nayrbryangaming.wixsite.com/nng-store",
            "TikTok": "https://www.tiktok.com/@nng_store?_t=8sdywlIzjIg&_r=1",
            "Facebook": "https://www.facebook.com/profile.php?id=61567061512465",
            "Instagram": "https://www.instagram.com/nngstoreofficial/profilecard/?igsh=cjI5eWFxMGFnd2Jz",
            "YouTube": "https://www.youtube.com/@NNGStore",
            # Add more platforms as needed
        }

        social_media_frame = ctk.CTkFrame(self.footer_frame)  # Create a frame for social media links
        social_media_frame.pack(side='top')  # Pack it below the copyright label

        for platform, url in social_media.items():
            link_label = ctk.CTkLabel(social_media_frame, text=platform, font=("Arial", 10), text_color="White", cursor="hand2")
            link_label.pack(side='left', padx=(5, 5))
            link_label.bind("<Button-1>", lambda e, url=url: webbrowser.open(url))  # Bind click event to open URL









    def create_circular_image(self, path, size=(700, 700)):
        """Create a circular image from a given path."""
        img = Image.open(path).convert("RGBA")
        img = img.resize(size, Image.LANCZOS)

        # Create a circular mask
        mask = Image.new("L", size, 0)
        draw = ImageDraw.Draw(mask)
        draw.ellipse((0, 0) + size, fill=255)

        # Apply mask to the image
        circular_img = Image.new("RGBA", size)
        circular_img.paste(img, (0, 0), mask)

        return circular_img


    def update_logo(self):
        """Load and display the current logo image."""
        logo_path = self.logo_images[self.current_image_index]
        
        # Open and resize the logo image
        logo_image = Image.open(logo_path)
        logo_image = logo_image.resize((250, 250), Image.LANCZOS)  # Resize if needed
        self.logo_photo = ImageTk.PhotoImage(logo_image)

        # Update the label with the new image
        self.logo_label.configure(image=self.logo_photo)
        
    def slideshow(self):
        """Change to the next logo image in the slideshow."""
        # Update index to show next image
        self.current_image_index = (self.current_image_index + 1) % len(self.logo_images)
        
        # Update the logo displayed in the label
        self.update_logo()
        
        # Schedule the next slideshow update
        self.after(3000, self.slideshow)  # Change image every 3 seconds


























class BViewProfileFrame(ctk.CTkFrame):
    def __init__(self, parent, controller):
        super().__init__(parent)
        self.controller = controller

        # Create a scrollable frame
        scrollable_frame = ctk.CTkScrollableFrame(self)
        scrollable_frame.pack(expand=True, fill="both", padx=20, pady=20)

        ctk.CTkLabel(scrollable_frame, text="Biodata Lengkap Anda", font=("Arial", 24)).pack(pady=20)

        profile_image_path = r"C:\\Users\\arche\\0(python VISUAL STUDIO CODE)\\Property\\you (2).jpg"  # Update with your actual image path
        self.profile_image = self.create_circular_image(profile_image_path, size=(500, 500))

        # Display profile image
        self.profile_photo = ImageTk.PhotoImage(self.profile_image)
        profile_label = ctk.CTkLabel(scrollable_frame, image=self.profile_photo)
        profile_label.pack(pady=10)




        # Dummy profile information for demonstration
        profile_info = {
            "Nama Panggilan": "Vin",
            "Nama Lengkap": "Vincentius Bryan Kwandou",
            "NIK": "7371091708000009",
            "Tempat Lahir": "Jayapura",
            "Tanggal Lahir": "17/08/2000",
            "Status Kewarganegaraan": "WNI",
            "Jenis Kelamin": "Pria",
            "Status Perkawinan": "Belum Menikah",
            "Golongan Darah": "O",
            "Rhesus": "Positif",
            "Pekerjaan": "Konten Kreator TikTok",
            "Lama Bekerja": "Lebih Dari 10 Tahun",
            "Alamat Tempat Kerja": "Jl. Urip No.5",
            "Alamat": "Jl. Urip No.5",
            "Nomor Telepon": "082293212721",
            "Penghasilan Per Bulan": "Rp 6.000.000",
            "Status BI Checking": "Kolektibilitas 1",
            "Jumlah Tabungan Saat Ini": "< Rp 50.000.000,-"
        }

        # Add each profile information label to the scrollable frame
        for label_text, info in profile_info.items():
            entry_frame = ctk.CTkFrame(scrollable_frame)
            entry_frame.pack(fill='x', pady=5)

            label = ctk.CTkLabel(entry_frame, text=f"{label_text}: {info}", font=("Arial", 10), anchor='w')
            label.pack(side='left', padx=(0, 10), fill='x')

        ctk.CTkButton(self, text="Kembali ke Dashboard", command=lambda: controller.show_frame("BuyerDashboardFrame")).pack(pady=20)



    def create_circular_image(self, path, size=(700, 700)):
        """Create a circular image from a given path."""
        img = Image.open(path).convert("RGBA")
        img = img.resize(size, Image.LANCZOS)

        # Create a circular mask
        mask = Image.new("L", size, 0)
        draw = ImageDraw.Draw(mask)
        draw.ellipse((0, 0) + size, fill=255)

        # Apply mask to the image
        circular_img = Image.new("RGBA", size)
        circular_img.paste(img, (0, 0), mask)

        return circular_img





























class BEditProfileFrame(ctk.CTkFrame):
    def __init__(self, parent, controller):
        super().__init__(parent)
        self.controller = controller

        scrollable_frame = ctk.CTkScrollableFrame(self)
        scrollable_frame.pack(expand=True, fill="both", padx=20, pady=20)

        ctk.CTkLabel(scrollable_frame, text="Edit Profile", font=("Arial", 24)).pack(pady=20)

 
        # Entry fields for profile details
        self.name_entry = ctk.CTkEntry(scrollable_frame, placeholder_text="Nama Lengkap")
        self.name_entry.pack(pady=10)

        self.email_entry = ctk.CTkEntry(scrollable_frame, placeholder_text="Email")
        self.email_entry.pack(pady=10)

        self.phone_entry = ctk.CTkEntry(scrollable_frame, placeholder_text="Nomor Telepon")
        self.phone_entry.pack(pady=10)

         # Date of Birth using tkcalendar DateEntry
        ctk.CTkLabel(scrollable_frame, text="Tanggal Lahir").pack(pady=(0))
        self.dob_entry = DateEntry(scrollable_frame, width=30)
        self.dob_entry.pack(pady=0)


# Dropdowns with labels for other attributes
        nationality_options = ["WNI", "WNA", "Kewarganegaraan Ganda", "Tanpa Kewarganegaraan"]
        gender_options = ["Pria", "Wanita"]
        marital_status_options = ["Belum Menikah", "Sudah Menikah"]
        blood_type_options = ["A", "B", "AB", "O"]
        rhesus_options = ["Positif", "Negatif"]
        work_duration_options = ["Kurang dari 1 Tahun", "1-3 Tahun", "3-5 Tahun", "5-10 Tahun", "Lebih Dari 10 Tahun"]
        income_options = ["<Rp 3.000.000", "Rp 3.000.000 - Rp 5.999.999", "Rp 6.000.000 - Rp 9.999.999", "Rp 10.000.000 - Rp 19.999.999", "Rp 20.000.000 - Rp 34.999.999" , "Rp 35.000.000 - Rp 50.000.000","> Rp 60.000.000"]
        bi_status_options = ["Kolektibilitas 1", "Kolektibilitas 2", "Kolektibilitas 3", "Kolektibilitas 4", "Kolektibilitas 5"]
        savings_options = ["< Rp 50.000.000", "Rp 50.000.000 - Rp 99.999.999","Rp 100.000.000 - Rp 499.999.999", "Rp 500.000.000 - Rp 999.999.999", "Rp 1.000.000.000 - Rp 10.000.000.000", "> Rp 10.000.000.000"]

         # Dropdowns with corresponding labels
        ctk.CTkLabel(scrollable_frame, text="Kewarganegaraan").pack(pady=(0))
        ctk.CTkOptionMenu(scrollable_frame, values=nationality_options).pack(pady=(5))

        ctk.CTkLabel(scrollable_frame, text="Jenis Kelamin").pack(pady=(0))
        ctk.CTkOptionMenu(scrollable_frame, values=gender_options).pack(pady=(5))

        ctk.CTkLabel(scrollable_frame, text="Status Perkawinan").pack(pady=(0))
        ctk.CTkOptionMenu(scrollable_frame, values=marital_status_options).pack(pady=(5))

        ctk.CTkLabel(scrollable_frame, text="Golongan Darah").pack(pady=(0))
        ctk.CTkOptionMenu(scrollable_frame, values=blood_type_options).pack(pady=(5))

        ctk.CTkLabel(scrollable_frame, text="Rhesus").pack(pady=(0))
        ctk.CTkOptionMenu(scrollable_frame, values=rhesus_options).pack(pady=(5))

        ctk.CTkLabel(scrollable_frame, text="Lama Bekerja").pack(pady=(0))
        ctk.CTkOptionMenu(scrollable_frame, values=work_duration_options).pack(pady=(5))

        ctk.CTkLabel(scrollable_frame, text="Penghasilan Per Bulan").pack(pady=(0))
        ctk.CTkOptionMenu(scrollable_frame, values=income_options).pack(pady=(5))

        ctk.CTkLabel(scrollable_frame, text="Status BI Checking").pack(pady=(0))
        ctk.CTkOptionMenu(scrollable_frame, values=bi_status_options).pack(pady=(5))

        ctk.CTkLabel(scrollable_frame, text="Jumlah Tabungan Saat Ini").pack(pady=(0))
        ctk.CTkOptionMenu(scrollable_frame, values=savings_options).pack(pady=(5))


        ctk.CTkButton(self, text="Simpan Perubahan", command=self.save_changes).pack(pady=40)

    def save_changes(self):
        full_name = self.name_entry.get()
        email = self.email_entry.get()
        phone_number = self.phone_entry.get()

        print(f"Profile Updated: Name: {full_name}, Email: {email}, Phone: {phone_number}")

         # Clear entry fields after saving.
        self.name_entry.delete(0, 'end')
        self.email_entry.delete(0, 'end')
        self.phone_entry.delete(0, 'end')

         # Optionally navigate back to the dashboard.
        self.controller.show_frame("BuyerDashboardFrame")




























# Frame Property List
class BPropertyListFrame(ctk.CTkFrame):
    def __init__(self, parent, controller):
        super().__init__(parent)
        self.controller = controller

        ctk.CTkLabel(self, text="Properti yang tersedia", font=("Arial", 24)).pack(pady=20)

        scrollable_frame = ctk.CTkScrollableFrame(self)
        scrollable_frame.pack(expand=True, fill="both", padx=20, pady=20)

        # Dummy property list with details
        properties = [
            {
                "Nama": "CitraLand City CPI Makassar - Golden Avenue",
                "Harga": "Mulai Rp 5.000.000.000",
                "Lokasi": "Mariso, Makassar",
                "Deskripsi": "Rumah 2 lantai dengan desain modern, luas bangunan 166 m², dan luas tanah 162 m²",
                "Detail Rumah": "3+1 kamar tidur, 4 kamar mandi, garasi untuk 1 mobil, daya listrik 3300 Watt, sumber air PAM, dan fitur smart home.",
                "Developer": "Ciputra",
                "Bank yang Bekerjasama": "BCA",
                "Image Path": r"C:\\Users\\arche\\0(python VISUAL STUDIO CODE)\\Property\\1.jpg"
            },





            {
                "Nama": "Summarecon Mutiara Makassar - Cluster Akasia",
                "Harga": "Mulai Rp 1.100.000.000 hingga Rp 2.100.000.000",
                "Lokasi": "Summarecon Mutiara Makassar, Biring Kanaya, Makassar",
                "Deskripsi": "Perumahan dengan konsep Aeroport City, dikembangkan di atas lahan seluas 400 hektar, dekat dengan bandara dan pelabuhan baru, serta memiliki akses tol langsung.",
                "Detail Rumah": "Beragam tipe rumah dengan fasilitas kolam renang, area bermain, ruang komunitas, lapangan basket, taman hijau, keamanan 24 jam, dan sekolah.",
                "Developer": "Summarecon",
                "Bank yang Bekerjasama": "BCA",
                "Image Path": r"C:\\Users\\arche\\0(python VISUAL STUDIO CODE)\\Property\\2.jpg"
            
            },
            {
                "Nama": "Summarecon Mutiara Makassar - Jade Residence",
                "Harga": "Mulai Rp 1.100.000.000",
                "Lokasi": "Summarecon Mutiara Makassar, Biring Kanaya, Makassar",
                "Deskripsi": "Hunian mewah dengan sentuhan gaya klasik yang mewakili kemapanan dan keanggunan dengan detail arsitektur yang kaya.",
                "Detail Rumah": "Beragam tipe rumah dengan fasilitas kolam renang, area bermain, ruang komunitas, lapangan basket, taman hijau, keamanan 24 jam, dan sekolah.",
                "Developer": "Summarecon",
                "Bank yang Bekerjasama": "BCA",
                "Image Path": r"C:\\Users\\arche\\0(python VISUAL STUDIO CODE)\\Property\\3.jpg"
            },
            {
                "Nama": "Summarecon Mutiara Makassar - Jade 2 Residence",
                "Harga": "Mulai Rp 2,2 miliar (termasuk PPN dan BPHTB)",
                "Lokasi": "Summarecon Mutiara Makassar,Biring Kanaya, Makassar",
                "Deskripsi": "Properti dengan desain modern klasik, menawarkan kenyamanan dan kemewahan bagi penghuninya.",
                "Detail Rumah": "-",
                "Developer": "Summarecon",
                "Bank yang Bekerjasama": "BCA",
                "Image Path": r"C:\Users\arche\0(python VISUAL STUDIO CODE)\Property\4.jpg"
            },
            {
                "Nama": "Summarecon Mutiara Makassar - The Topaz Residence",
                "Harga": "Mulai Rp 2,1 miliar (termasuk PPN dan BPHTB)",
                "Lokasi": "Summarecon Mutiara Makassar,Biring Kanaya, Makassar",
                "Deskripsi": "Cluster dengan desain modern, menawarkan kenyamanan bagi penghuninya.",
                "Detail Rumah": "-",
                "Developer": "Summarecon",
                "Bank yang Bekerjasama": "BCA",
                "Image Path": r"C:\Users\arche\0(python VISUAL STUDIO CODE)\Property\5.jpg"
            },
            {
                "Nama": "Summarecon Mutiara Makassar - The Topaz Residence Type Sherry",
                "Harga": "Mulai Rp 2,5 miliar (termasuk PPN dan BPHTB)",
                "Lokasi": "Summarecon Mutiara Makassar,Biring Kanaya, Makassar",
                "Deskripsi": "Hunian dengan desain modern yang memukau, menggabungkan elegansi dan kenyamanan.",
                "Detail Rumah": "-",
                "Developer": "Summarecon",
                "Bank yang Bekerjasama": "BCA",
                "Image Path": r"C:\Users\arche\0(python VISUAL STUDIO CODE)\Property\6.jpg"
            },
            {
                "Nama": "Summarecon Mutiara Makassar - Beryl Residence",
                "Harga": "Mulai Rp 1,2 miliar (termasuk PPN dan BPHTB)",
                "Lokasi": "Summarecon Mutiara Makassar,Biring Kanaya, Makassar",
                "Deskripsi": "Cluster dengan fasilitas umum seperti kolam renang, clubhouse, dan area bermain anak.",
                "Detail Rumah": "-",
                "Developer": "Summarecon",
                "Bank yang Bekerjasama": "BCA",
                "Image Path": r"C:\Users\arche\0(python VISUAL STUDIO CODE)\Property\7.jpg"
            },
            {
                "Nama": "Summarecon Mutiara Makassar - Blue Crystal",
                "Harga": "Mulai Rp 2 miliar (termasuk PPN dan BPHTB)",
                "Lokasi": "Summarecon Mutiara Makassar,Biring Kanaya, Makassar",
                "Deskripsi": "Cluster dengan desain tropis kontemporer, dilengkapi fasilitas umum yang mendukung kenyamanan penghuni.",
                "Detail Rumah": "-",
                "Developer": "Summarecon",
                "Bank yang Bekerjasama": "BCA",
                "Image Path": r"C:\Users\arche\0(python VISUAL STUDIO CODE)\Property\8.jpg"
            },
            {
                "Nama": "Summarecon Mutiara Makassar - Green Crystal",
                "Harga": "Mulai Rp 2 miliar (termasuk PPN dan BPHTB)",
                "Lokasi": "Summarecon Mutiara Makassar,Biring Kanaya, Makassar",
                "Deskripsi": "Cluster dengan fasilitas modern, menawarkan kenyamanan dan kemewahan bagi penghuninya.",
                "Detail Rumah": "-",
                "Developer": "Summarecon",
                "Bank yang Bekerjasama": "BCA",
                "Image Path": r"C:\Users\arche\0(python VISUAL STUDIO CODE)\Property\9.jpg"
            },
            {
                "Nama": "Summarecon Mutiara Makassar - The Morizen Makassar",
                "Harga": "Mulai Rp 10 miliar (termasuk PPN dan BPHTB)",
                "Lokasi": "Summarecon Mutiara Makassar,Biring Kanaya, Makassar",
                "Deskripsi": "Hunian dengan konsep Jepang, menawarkan keseimbangan antara elegansi dan kenyamanan.",
                "Detail Rumah": "-",
                "Developer": "Summarecon",
                "Bank yang Bekerjasama": "BCA",
                "Image Path": r"C:\Users\arche\0(python VISUAL STUDIO CODE)\Property\10.jpg"
            },
            {
                "Nama": "Summarecon Mutiara Makassar - Ruko Graha Boulevard Makassar",
                "Harga": "Mulai Rp 1,5 miliar (termasuk PPN dan BPHTB)",
                "Lokasi": "Summarecon Mutiara Makassar,Biring Kanaya, Makassar",
                "Deskripsi": "Ruko 3 lantai dengan lokasi strategis, cocok untuk berbagai jenis usaha. ",
                "Detail Rumah": "Luas bangunan 115 m², 1 kamar mandi",
                "Developer": "Summarecon",
                "Bank yang Bekerjasama": "BCA",
                "Image Path": r"C:\Users\arche\0(python VISUAL STUDIO CODE)\Property\11.jpg"
            },






            {
                "Nama": "Virginia Park Makassar",
                "Harga": "Mulai Rp 1.000.000.000 hingga Rp 2.000.000.000",
                "Lokasi": "Biring Kanaya, Makassar",
                "Deskripsi": "Perumahan mewah dengan konsep Luxury Home with Green Development Concept, menawarkan hunian mewah dengan lingkungan hijau yang nyaman.",
                "Detail Rumah": "-",
                "Developer": "Brighton Real Estate",
                "Bank yang Bekerjasama": "-",
                "Image Path": r"C:\Users\arche\0(python VISUAL STUDIO CODE)\Property\12.jpg"
            },
             {
                "Nama": "Perumahan Grand Barombong",
                "Harga": "Rp 177.000.000",
                "Lokasi": "Makassar",
                "Deskripsi": "Rumah tinggal 1 lantai dengan lokasi strategis dan harga terjangkau.",
                "Detail Rumah": "Luas tanah 72 m², luas bangunan 36 m².",
                "Developer": "-",
                "Bank yang Bekerjasama": "-",
                "Image Path": r"C:\Users\arche\0(python VISUAL STUDIO CODE)\Property\13.jpg"
            },
             {
                "Nama": "Royal Sentraland BTP Makassar",
                "Harga": "Rp 330.000.000",
                "Lokasi": "Makassar",
                "Deskripsi": "Rumah tinggal 2 lantai dengan 3 kamar tidur dan 3 kamar mandi.",
                "Detail Rumah": "Luas tanah 84 m², luas bangunan 84 m².",
                "Developer": "-",
                "Bank yang Bekerjasama": "-",
                "Image Path": r"C:\Users\arche\0(python VISUAL STUDIO CODE)\Property\14.jpg"
            },
            {
                "Nama": "Rumah Tengah Kota Makassar",
                "Harga": "Mulai Rp 588.000.000",
                "Lokasi": "Makassar",
                "Deskripsi": "Rumah tersedia dalam 2 tipe, 1 dan 2 lantai, dengan opsi cicilan developer maksimal 3 tahun tanpa bank dan tanpa bunga.",
                "Detail Rumah": "-",
                "Developer": "Rajata",
                "Bank yang Bekerjasama": "-",
                "Image Path": r"C:\Users\arche\0(python VISUAL STUDIO CODE)\Property\15.jpg"
            },
             {
                "Nama": "Perumahan Green Residence Sudiang",
                "Harga": "Mulai Rp 700.000.000",
                "Lokasi": "Sudiang, Makassar",
                "Deskripsi": " Kawasan ramah lingkungan dengan fasilitas taman hijau dan sistem cluster.",
                "Detail Rumah": "Rumah 1 lantai, 2 kamar tidur, 1 kamar mandi, luas tanah 72 m².",
                "Developer": "GreenLand Developer",
                "Bank yang Bekerjasama": "Bank Mandiri, BNI",
                "Image Path": r"C:\Users\arche\0(python VISUAL STUDIO CODE)\Property\16.jpg"
            },
            {
                "Nama": "Perumahan Taman Sari Makassar",
                "Harga": "Mulai Rp 1.200.000.000",
                "Lokasi": "Tamalanrea, Makassar",
                "Deskripsi": "Perumahan dengan konsep modern minimalis, dilengkapi dengan fasilitas keamanan 24 jam dan taman bermain anak.",
                "Detail Rumah": "Rumah 2 lantai, 3 kamar tidur, 2 kamar mandi, luas tanah 90 m².",
                "Developer": "PT. Taman Sari Makassar",
                "Bank yang Bekerjasama": "BCA, BRI",
                "Image Path": r"C:\Users\arche\0(python VISUAL STUDIO CODE)\Property\17.jpg"
            },
             {
                "Nama": "Perumahan Bukit Baruga Antang",
                "Harga": "Mulai Rp 900.000.000",
                "Lokasi": "Antang, Makassar",
                "Deskripsi": "Perumahan dengan lingkungan asri,",
                "Detail Rumah": "-",
                "Developer": "Bukit Baruga",
                "Bank yang Bekerjasama": "BCA",
                "Image Path": r"C:\Users\arche\0(python VISUAL STUDIO CODE)\Property\18.jpg"
            },
             
            
        ]

        for property in properties:
            # Create a frame for each property
            property_frame = ctk.CTkFrame(scrollable_frame)
            property_frame.pack(fill='x', padx=5, pady=5)
            img_path = property.get("Image Path")
            # Load and display the property image
            img_path = property["Image Path"]
            if img_path:  # Check if img_path is not None
                img = Image.open(img_path)
                img = img.resize((400, 400), Image.LANCZOS)  # Resize as needed
                img_photo = ImageTk.PhotoImage(img)

        # Create labels for the image and text
                image_label = ctk.CTkLabel(property_frame, image=img_photo)
                image_label.image = img_photo  # Keep a reference to avoid garbage collection
                image_label.grid(row=0, column=0, padx=10)

            # Create a frame for text information
            text_frame = ctk.CTkFrame(property_frame)
            text_frame.grid(row=0, column=1, padx=10)

            # Add property details to the text frame
            ctk.CTkLabel(text_frame, text="Nama: ", font=("Arial", 14)).grid(row=0, column=0, sticky="w")
            ctk.CTkLabel(text_frame, text=property["Nama"], font=("Arial", 14)).grid(row=0, column=1, sticky="w")

            ctk.CTkLabel(text_frame, text="Harga: ", font=("Arial", 14)).grid(row=1, column=0, sticky="w")
            ctk.CTkLabel(text_frame, text=property["Harga"], font=("Arial", 14)).grid(row=1, column=1, sticky="w")

            ctk.CTkLabel(text_frame, text="Lokasi: ", font=("Arial", 14)).grid(row=2, column=0, sticky="w")
            ctk.CTkLabel(text_frame, text=property["Lokasi"], font=("Arial", 14)).grid(row=2, column=1, sticky="w")

            ctk.CTkLabel(text_frame, text="Deskripsi: ", font=("Arial", 14)).grid(row=3, column=0, sticky="w")
            ctk.CTkLabel(text_frame, text=property["Deskripsi"], font=("Arial", 12), text_color="gray").grid(row=3, column=1, sticky="w")

            ctk.CTkLabel(text_frame, text="Detail Rumah: ", font=("Arial", 14)).grid(row=4, column=0, sticky="w")
            ctk.CTkLabel(text_frame, text=property["Detail Rumah"], font=("Arial", 12), text_color="gray").grid(row=4, column=1, sticky="w")

            ctk.CTkLabel(text_frame, text="Developer: ", font=("Arial", 14)).grid(row=5, column=0, sticky="w")
            ctk.CTkLabel(text_frame, text=property["Developer"], font=("Arial", 12), text_color="gray").grid(row=5, column=1, sticky="w")

            ctk.CTkLabel(text_frame, text="Bank yang Bekerjasama: ", font=("Arial", 14)).grid(row=6, column=0, sticky="w")
            ctk.CTkLabel(text_frame, text=property["Bank yang Bekerjasama"], font=("Arial", 12), text_color="gray").grid(row=6, column=1, sticky="w")
        # Back button to return to the dashboard
        ctk.CTkButton(self,
                      text="Kembali ke Dashboard",
                      command=lambda: controller.show_frame("BuyerDashboardFrame")).pack(pady=(10))
        
























# Frame Add Property
class BAddPropertyFrame(ctk.CTkFrame):
    def __init__(self, parent, controller):
        super().__init__(parent)
        self.controller = controller



        ctk.CTkLabel(self, text="Silahkan Masukkan Detail Properti yang Anda Inginkan", font=("Arial", 24)).pack(pady=20)

        scrollable_frame = ctk.CTkScrollableFrame(self)
        scrollable_frame.pack(expand=True, fill="both", padx=20, pady=20)
        
        # Entry fields for new property details
        # Input untuk menambahkan properti
        self.property_name_entry = ctk.CTkEntry(scrollable_frame, placeholder_text="Nama Properti")
        self.property_name_entry.pack(pady=10)

        self.property_price_entry = ctk.CTkEntry(scrollable_frame, placeholder_text="Budget")
        self.property_price_entry.pack(pady=10)

        self.property_location_entry = ctk.CTkEntry(scrollable_frame, placeholder_text="Lokasi")
        self.property_location_entry.pack(pady=10)

# Pertanyaan Kebutuhan
        # Kebutuhan (Sewa/Beli)
        self.needs_label = ctk.CTkLabel(scrollable_frame, text="Kebutuhan (Sewa/Beli):")
        self.needs_label.pack(pady=5)

        self.needs_var = ctk.StringVar(value="sewa")  # Default value
        ctk.CTkRadioButton(scrollable_frame, text="Sewa", variable=self.needs_var, value="sewa").pack(pady=5)
        ctk.CTkRadioButton(scrollable_frame, text="Beli", variable=self.needs_var, value="beli").pack(pady=5)

# Tujuan Membeli
        self.purpose_label = ctk.CTkLabel(scrollable_frame, text="Tujuan Membeli (Investasi/Tempat Tinggal):")
        self.purpose_label.pack(pady=5)

        self.purpose_var = ctk.StringVar(value="investasi")  # Default value
        ctk.CTkRadioButton(scrollable_frame, text="Investasi", variable=self.purpose_var, value="investasi").pack(pady=5)
        ctk.CTkRadioButton(scrollable_frame, text="Tempat Tinggal", variable=self.purpose_var, value="tempat_tinggal").pack(pady=5)

# Fasilitas Tambahan
        # Fasilitas Tambahan (Dropdown)
        self.facilities_label = ctk.CTkLabel(scrollable_frame, text="Fasilitas Tambahan:")
        self.facilities_label.pack(pady=5)

        self.facilities_options = ["Tandon", "Mesin Air", "Sumur Bor", "Kolam Renang", "Taman"]
        self.facilities_var = ctk.StringVar(value=self.facilities_options[0])  # Default value
        self.facilities_menu = ctk.CTkOptionMenu(scrollable_frame, variable=self.facilities_var, values=self.facilities_options)
        self.facilities_menu.pack(pady=10)

# Budget Range
        self.budget_range_label = ctk.CTkLabel(scrollable_frame, text="Budget Range:")
        self.budget_range_label.pack(pady=5)
        self.budget_range_entry = ctk.CTkEntry(scrollable_frame, placeholder_text="Range Budget")
        self.budget_range_entry.pack(pady=10)

# Untuk Penyewa
        # Untuk Penyewa (DP atau Cash Keras - Radio Button)
        self.dp_cash_label = ctk.CTkLabel(scrollable_frame, text="DP atau Cash Keras:")
        self.dp_cash_label.pack(pady=5)

        self.dp_cash_var = ctk.StringVar(value="dp")  # Default value
        ctk.CTkRadioButton(scrollable_frame, text="DP", variable=self.dp_cash_var, value="dp").pack(pady=5)
        ctk.CTkRadioButton(scrollable_frame, text="Cash Keras", variable=self.dp_cash_var, value="cash").pack(pady=5)

# Jangka Waktu Sewa yang Diinginkan (Dropdown)
        self.rent_duration_label = ctk.CTkLabel(scrollable_frame, text="Jangka Waktu Sewa yang Diinginkan:")
        self.rent_duration_label.pack(pady=5)

        self.rent_duration_options = ["1 Bulan", "3 Bulan", "6 Bulan", "1 Tahun"]
        self.rent_duration_var = ctk.StringVar(value=self.rent_duration_options[0])  # Default value
        self.rent_duration_menu = ctk.CTkOptionMenu(scrollable_frame, variable=self.rent_duration_var, values=self.rent_duration_options)
        self.rent_duration_menu.pack(pady=10)


        self.rent_budget_label = ctk.CTkLabel(scrollable_frame, text="Anggaran Sewa:")
        self.rent_budget_label.pack(pady=5)
        self.rent_budget_entry = ctk.CTkEntry(scrollable_frame, placeholder_text="Anggaran Sewa")
        self.rent_budget_entry.pack(pady=10)

        # Butuh Full Perabot atau Pakai Perabot Sendiri? (Radio Button)
        self.furnishing_label = ctk.CTkLabel(scrollable_frame, text="Butuh Full Perabot atau Pakai Perabot Sendiri?")
        self.furnishing_label.pack(pady=5)

        self.furnishing_var = ctk.StringVar(value="full")  # Default value
        ctk.CTkRadioButton(scrollable_frame, text="Full Perabot", variable=self.furnishing_var, value="full").pack(pady=5)
        ctk.CTkRadioButton(scrollable_frame, text="Pakai Perabot Sendiri", variable=self.furnishing_var, value="sendiri").pack(pady=5)

# Apakah KPR? (Radio Button)
        self.mortgage_label = ctk.CTkLabel(scrollable_frame, text="Apakah KPR? (Ya/Tidak):")
        self.mortgage_label.pack(pady=5)

        self.mortgage_var = ctk.StringVar(value="tidak")  # Default value
        ctk.CTkRadioButton(scrollable_frame, text="Ya", variable=self.mortgage_var, value="ya").pack(pady=5)
        ctk.CTkRadioButton(scrollable_frame, text="Tidak", variable=self.mortgage_var, value="tidak").pack(pady=5)

# Apakah Cicil? (Radio Button)
        self.installment_label = ctk.CTkLabel(scrollable_frame, text="Apakah Cicil? (Ya/Tidak):")
        self.installment_label.pack(pady=5)

        self.installment_var = ctk.StringVar(value="tidak")  # Default value
        ctk.CTkRadioButton(scrollable_frame, text="Ya", variable=self.installment_var, value="ya").pack(pady=5)
        ctk.CTkRadioButton(scrollable_frame, text="Tidak", variable=self.installment_var, value="tidak").pack(pady=5)

# Lama Cicilan (Dropdown)
        self.installment_duration_label = ctk.CTkLabel(scrollable_frame, text="Lama Cicilan (khusus cicilan):")
        self.installment_duration_label.pack(pady=5)

        self.installment_duration_options = ["1 Bulan", "3 Bulan", "6 Bulan", "1 Tahun"]
        self.installment_duration_var = ctk.StringVar(value=self.installment_duration_options[0])  # Default value
        self.installment_duration_menu = ctk.CTkOptionMenu(scrollable_frame, variable=self.installment_duration_var, values=self.installment_duration_options)
        self.installment_duration_menu.pack(pady=10)

# Bank yang Digunakan (Dropdown)
        self.bank_label = ctk.CTkLabel(scrollable_frame, text="Menggunakan Bank Apa?")
        self.bank_label.pack(pady=5)

        self.bank_options = ["BCA", "Mandiri", "BNI", "BRI"]
        self.bank_var = ctk.StringVar(value=self.bank_options[0])  # Default value
        self.bank_menu = ctk.CTkOptionMenu(scrollable_frame, variable=self.bank_var, values=self.bank_options)
        self.bank_menu.pack(pady=10)



        # NPWP Entry
        self.npwp_entry = ctk.CTkEntry(scrollable_frame, placeholder_text="NPWP", width=200)
        self.npwp_entry.pack(pady=5)


        self.ktp_button = ctk.CTkButton(scrollable_frame, text="Upload KTP", command=self.upload_ktp, width=100, height=100)
        self.ktp_button.pack(pady=(10))

        self.kartu_keluarga_button = ctk.CTkButton(scrollable_frame, text="Upload Kartu Keluarga", command=self.upload_kartu_keluarga, width=100, height=100)
        self.kartu_keluarga_button.pack(pady=(10))

        self.slip_gaji_button = ctk.CTkButton(scrollable_frame, text="Upload Slip Gaji", command=self.upload_slip_gaji, width=100, height=100)
        self.slip_gaji_button.pack(pady=(10))

        self.slip_pajak_button = ctk.CTkButton(scrollable_frame, text="Upload Slip Pajak", command=self.upload_slip_pajak, width=100, height=100)
        self.slip_pajak_button.pack(pady=(10))






        ctk.CTkButton(self, text="Ajukan Pembelian Properti", command=self.add_property).pack(pady=20)









    def upload_ktp(self):
        file_path = filedialog.askopenfilename(title="Upload KTP", filetypes=[("Image Files", "*.jpg;*.jpeg;*.png")])
        
        if file_path:
            filename = file_path.split("/")[-1]  # Get the file name from the path
            self.ktp_button.configure(text=f"KTP: {filename}")  # Update button text with the file name

    def upload_kartu_keluarga(self):
        file_path = filedialog.askopenfilename(title="Upload Kartu Keluarga", filetypes=[("Image Files", "*.jpg;*.jpeg;*.png")])
        
        if file_path:
            filename = file_path.split("/")[-1]  # Get the file name from the path
            self.kartu_keluarga_button.configure(text=f"Kartu Keluarga: {filename}")  # Update button text with the file name

    def upload_slip_gaji(self):
        file_path = filedialog.askopenfilename(title="Upload Slip Gaji", filetypes=[("Image Files", "*.jpg;*.jpeg;*.png")])
        
        if file_path:
            filename = file_path.split("/")[-1]  # Get the file name from the path
            self.slip_gaji_button.configure(text=f"Slip Gaji: {filename}")  # Update button text with the file name

    def upload_slip_pajak(self):
        file_path = filedialog.askopenfilename(title="Upload Slip Pajak", filetypes=[("Image Files", "*.jpg;*.jpeg;*.png")])
        
        if file_path:
            filename = file_path.split("/")[-1]  # Get the file name from the path
            self.slip_pajak_button.configure(text=f"Slip Pajak: {filename}")  # Update button text with the file name










   

    def add_property(self):
         # Logic to add the property would go here.
        property_name = self.property_name_entry.get()
        property_price = self.property_price_entry.get()
        property_location = self.property_location_entry.get()
         
        print(f"Added Property: {property_name}, Price: {property_price}, Location: {property_location}")
         
         # Clear entry fields after adding.
        self.property_name_entry.delete(0, 'end')
        self.property_price_entry.delete(0, 'end')
        self.property_location_entry.delete(0, 'end')

         # Optionally navigate back to the dashboard or show a success message.
        self.controller.show_frame("BuyerDashboardFrame")

    



















# Frame Logout
class BLogoutFrame(ctk.CTkFrame):
    def __init__(self, parent, controller):
        super().__init__(parent)
        self.controller = controller

        ctk.CTkLabel(self, text="Anda telah berhasil keluar dari akun anda", font=("Arial", 24)).pack(pady=20)
        
        ctk.CTkButton(self, text="Login Kembali", command=lambda: controller.show_frame("LoginFrame")).pack(pady=10)
























class ContactSalesFrame(ctk.CTkFrame):
    def __init__(self, parent, controller):
        super().__init__(parent)
        self.controller = controller
        
        # Sample data for sales agents
        self.sales_agents = [
            {
                "name": "Vincentius Bryan Kwandou",
                "phone": "+6282293212721",
                "email": "wall.breaker.king.commander@gmail.com",
                "rating": 5,
                "photo": r"C:\Users\arche\0(python VISUAL STUDIO CODE)\Property\me.jpg"  # Update with actual photo path
            },
            {
                "name": "nayrbryanGaming",
                "phone": "+628986861717",
                "email": "archer.king.commander@gmail.com",
                "rating": 5,
                "photo": r"C:\Users\arche\0(python VISUAL STUDIO CODE)\Property\me.jpg"  # Update with actual photo path
            },
            {
                "name": "VinBryYT",
                "phone": "+62895365173030",
                "email": "VinBryYT2000@gmail.com",
                "rating": 4,
                "photo": r"C:\Users\arche\0(python VISUAL STUDIO CODE)\Property\me.jpg"  # Update with actual photo path
            }
        ]

        # Create a scrollable frame for the sales agents list
        scrollable_frame = ctk.CTkScrollableFrame(self)
        scrollable_frame.pack(expand=True, fill="both", padx=20, pady=20)

        # Display each agent's information
        for agent in self.sales_agents:
            self.create_agent_info(scrollable_frame, agent)

        # Back button to return to the dashboard
        ctk.CTkButton(self, text="Kembali ke Dashboard", command=lambda: controller.show_frame("BuyerDashboardFrame")).pack(pady=20)

    def create_agent_info(self, parent, agent):
        """Create and pack labels for each agent's information."""
        agent_frame = ctk.CTkFrame(parent)
        agent_frame.pack(fill='x', pady=10)

        # Create circular image
        circular_image = self.create_circular_image(agent['photo'], size=(200, 200))  # Set desired size for the circular image
        self.profile_photo = ImageTk.PhotoImage(circular_image)

        # Display profile image on the left side
        profile_label = ctk.CTkLabel(agent_frame, image=self.profile_photo)
        profile_label.pack(side='left', padx=(0, 10))

        # Name
        ctk.CTkLabel(agent_frame, text=f"Nama: {agent['name']}", font=("Arial", 12)).pack(anchor='w')

        # Phone
        ctk.CTkLabel(agent_frame, text=f"Telepon: {agent['phone']}", font=("Arial", 12)).pack(anchor='w')

        # Email
        ctk.CTkLabel(agent_frame, text=f"Email: {agent['email']}", font=("Arial", 12)).pack(anchor='w')

        # Rating
        ctk.CTkLabel(agent_frame, text=f"Rating: {agent['rating']}", font=("Arial", 12)).pack(anchor='w')

        # Contact Button
        contact_button = ctk.CTkButton(agent_frame, text="Hubungi", command=lambda: self.open_chat(agent))
        contact_button.pack(side='right', padx=(10, 0))

    def open_chat(self, agent):
        """Open chat window for the selected agent."""
        chat_window = ChatFrame(self.controller, agent)
        chat_window.grab_set()  # Make the chat window modal (optional)

    def create_circular_image(self, path, size=(200, 200)):
        """Create a circular image from a given path."""
        img = Image.open(path).convert("RGBA")
        img = img.resize(size, Image.LANCZOS)

        # Create a circular mask
        mask = Image.new("L", size, 0)
        draw = ImageDraw.Draw(mask)
        draw.ellipse((0, 0) + size, fill=255)

        # Apply mask to the image
        circular_img = Image.new("RGBA", size)
        circular_img.paste(img, (0, 0), mask)

        return circular_img











class ChatFrame(ctk.CTkToplevel):  # Use CTkToplevel for pop-up window
    def __init__(self, parent, agent):
        super().__init__(parent)
        
        self.agent = agent

        self.title(f"Personal Chat dengan {agent['name']}")  # Set window title

        ctk.CTkLabel(self, text=f"Chat dengan {agent['name']}", font=("Arial", 24)).pack(pady=20)

        self.chat_area = ctk.CTkTextbox(self)
        self.chat_area.pack(expand=True, fill="both", padx=20, pady=20)

        self.message_entry = ctk.CTkEntry(self, placeholder_text="Tulis pesan...", width=400)
        self.message_entry.pack(side='left', padx=(20, 5), pady=(0, 20))

        self.send_button = ctk.CTkButton(self, text="Kirim", command=self.send_message)
        self.send_button.pack(side='right', padx=(5, 20), pady=(0, 20))

    def send_message(self):
        message = self.message_entry.get()
        
        if message:
            self.chat_area.insert('end', f"You: {message}\n")  # Display sent message in chat area
            self.message_entry.delete(0, 'end')  # Clear entry field













class ChatbotFrame(ctk.CTkFrame):
    def __init__(self, parent, controller):
        super().__init__(parent)
        self.controller = controller
        
        ctk.CTkLabel(self, text="Chatbot FAQ", font=("Arial", 24)).pack(pady=20)

        # Daftar pertanyaan dan jawaban
        self.faqs = {
            "aplikasi apa ini?": "Ini adalah aplikasi manajemen properti yang bisa digunakan baik untuk pihak Agen sebagai perantara, pihak vendor yang ingin menjual maupun menyewakan properti miliknya, maupun pihak user sebagai pembeli yang ingin membeli properti baik sebagai nilai investasi maupun sebagai tempat hunian",
            "Apa saja jenis properti yang tersedia?": "Kami memiliki berbagai jenis properti termasuk rumah, apartemen, dan ruko.",
            "apakah penggunaan aplikasi ini dikenakan biaya platform?": "tidak, kami berkomitmen untuk memberikan pelayanan terbaik secara cuma-cuma untuk seluruh pelanggan serta mitra kami",
            "Bagaimana cara melihat detail informasi profil saya?": "Masuk ke menu Profil di halaman utama, dan Anda akan melihat data pribadi Anda seperti nama, alamat email, dan nomor telepon.",
            "Apakah saya bisa mengganti alamat email yang terdaftar?": "Ya, Anda dapat mengganti alamat email di menu Edit Profil",
            "Apakah ada batasan untuk mengedit profil?": "Tidak ada batasan, tetapi semua perubahan harus disimpan untuk berlaku.",
            "Bagaimana jika saya lupa kata sandi?": "Klik 'Lupa Kata Sandi' di halaman login untuk mereset kata sandi Anda melalui email.",
            
            "Bagaimana cara melihat detail properti tertentu?": "Klik pada properti yang ingin Anda lihat, dan detail lengkap akan ditampilkan, termasuk harga, deskripsi,Vendor,Lokasi,dll",
            "Bagaimana cara menambahkan properti saya ke daftar?": " Masuk ke menu Ajukan Penambahan Properti, isi detail properti seperti alamat, harga, dan foto, lalu kirim untuk disetujui.",
            "Berapa lama waktu persetujuan untuk menambahkan properti?": "Biasanya membutuhkan waktu 1-3 hari kerja untuk persetujuan dari tim kami."
            
            
        }

        # Menampilkan pertanyaan
        for question in self.faqs.keys():
            button = ctk.CTkButton(self, text=question, command=lambda q=question: self.show_answer(q), width=400)
            button.pack(pady=1)

        self.jawaban_header_label = ctk.CTkLabel(self, text="Jawaban:")
        self.jawaban_header_label.pack(pady=0)

        self.answer_content_label = ctk.CTkLabel(
        self,
        text="", 
        font=("Arial", 12),
        wraplength=400,
        height=5 # Atur tinggi label sesuai kebutuhan
)
        self.answer_content_label.pack(pady=0)


        ctk.CTkButton(self, text="Kembali ke Dashboard", command=lambda: controller.show_frame("BuyerDashboardFrame")).pack(pady=20)

    def show_answer(self, question):
        answer = self.faqs[question]
        self.answer_content_label.configure(text=answer)  # Update label konten jawaban
























class BPropertyListFrame(ctk.CTkFrame):
    def __init__(self, parent, controller):
        super().__init__(parent)
        self.controller = controller

        
        ctk.CTkLabel(self, text="Properti yang tersedia", font=("Arial", 24)).pack(pady=20)

        scrollable_frame = ctk.CTkScrollableFrame(self)
        scrollable_frame.pack(expand=True, fill="both", padx=20, pady=20)

        # Dummy property list with details
        properties = [
            {
                "Nama": "CitraLand City CPI Makassar - Golden Avenue",
                "Harga": "Mulai Rp 5.000.000.000",
                "Lokasi": "Mariso, Makassar",
                "Deskripsi": "Rumah 2 lantai dengan desain modern, luas bangunan 166 m², dan luas tanah 162 m²",
                "Detail Rumah": "3+1 kamar tidur, 4 kamar mandi, garasi untuk 1 mobil, daya listrik 3300 Watt, sumber air PAM, dan fitur smart home.",
                "Developer": "Ciputra",
                "Bank yang Bekerjasama": "BCA",
                "Image Path": r"C:\\Users\\arche\\0(python VISUAL STUDIO CODE)\\Property\\1.jpg"
            },





            {
                "Nama": "Summarecon Mutiara Makassar - Cluster Akasia",
                "Harga": "Mulai Rp 1.100.000.000 hingga Rp 2.100.000.000",
                "Lokasi": "Summarecon Mutiara Makassar, Biring Kanaya, Makassar",
                "Deskripsi": "Perumahan dengan konsep Aeroport City, dikembangkan di atas lahan seluas 400 hektar, dekat dengan bandara dan pelabuhan baru, serta memiliki akses tol langsung.",
                "Detail Rumah": "Beragam tipe rumah dengan fasilitas kolam renang, area bermain, ruang komunitas, lapangan basket, taman hijau, keamanan 24 jam, dan sekolah.",
                "Developer": "Summarecon",
                "Bank yang Bekerjasama": "BCA",
                "Image Path": r"C:\\Users\\arche\\0(python VISUAL STUDIO CODE)\\Property\\2.jpg"
            
            },
            {
                "Nama": "Summarecon Mutiara Makassar - Jade Residence",
                "Harga": "Mulai Rp 1.100.000.000",
                "Lokasi": "Summarecon Mutiara Makassar, Biring Kanaya, Makassar",
                "Deskripsi": "Hunian mewah dengan sentuhan gaya klasik yang mewakili kemapanan dan keanggunan dengan detail arsitektur yang kaya.",
                "Detail Rumah": "Beragam tipe rumah dengan fasilitas kolam renang, area bermain, ruang komunitas, lapangan basket, taman hijau, keamanan 24 jam, dan sekolah.",
                "Developer": "Summarecon",
                "Bank yang Bekerjasama": "BCA",
                "Image Path": r"C:\\Users\\arche\\0(python VISUAL STUDIO CODE)\\Property\\3.jpg"
            },
            {
                "Nama": "Summarecon Mutiara Makassar - Jade 2 Residence",
                "Harga": "Mulai Rp 2,2 miliar (termasuk PPN dan BPHTB)",
                "Lokasi": "Summarecon Mutiara Makassar,Biring Kanaya, Makassar",
                "Deskripsi": "Properti dengan desain modern klasik, menawarkan kenyamanan dan kemewahan bagi penghuninya.",
                "Detail Rumah": "-",
                "Developer": "Summarecon",
                "Bank yang Bekerjasama": "BCA",
                "Image Path": r"C:\Users\arche\0(python VISUAL STUDIO CODE)\Property\4.jpg"
            },
            {
                "Nama": "Summarecon Mutiara Makassar - The Topaz Residence",
                "Harga": "Mulai Rp 2,1 miliar (termasuk PPN dan BPHTB)",
                "Lokasi": "Summarecon Mutiara Makassar,Biring Kanaya, Makassar",
                "Deskripsi": "Cluster dengan desain modern, menawarkan kenyamanan bagi penghuninya.",
                "Detail Rumah": "-",
                "Developer": "Summarecon",
                "Bank yang Bekerjasama": "BCA",
                "Image Path": r"C:\Users\arche\0(python VISUAL STUDIO CODE)\Property\5.jpg"
            },
            {
                "Nama": "Summarecon Mutiara Makassar - The Topaz Residence Type Sherry",
                "Harga": "Mulai Rp 2,5 miliar (termasuk PPN dan BPHTB)",
                "Lokasi": "Summarecon Mutiara Makassar,Biring Kanaya, Makassar",
                "Deskripsi": "Hunian dengan desain modern yang memukau, menggabungkan elegansi dan kenyamanan.",
                "Detail Rumah": "-",
                "Developer": "Summarecon",
                "Bank yang Bekerjasama": "BCA",
                "Image Path": r"C:\Users\arche\0(python VISUAL STUDIO CODE)\Property\6.jpg"
            },
            {
                "Nama": "Summarecon Mutiara Makassar - Beryl Residence",
                "Harga": "Mulai Rp 1,2 miliar (termasuk PPN dan BPHTB)",
                "Lokasi": "Summarecon Mutiara Makassar,Biring Kanaya, Makassar",
                "Deskripsi": "Cluster dengan fasilitas umum seperti kolam renang, clubhouse, dan area bermain anak.",
                "Detail Rumah": "-",
                "Developer": "Summarecon",
                "Bank yang Bekerjasama": "BCA",
                "Image Path": r"C:\Users\arche\0(python VISUAL STUDIO CODE)\Property\7.jpg"
            },
            {
                "Nama": "Summarecon Mutiara Makassar - Blue Crystal",
                "Harga": "Mulai Rp 2 miliar (termasuk PPN dan BPHTB)",
                "Lokasi": "Summarecon Mutiara Makassar,Biring Kanaya, Makassar",
                "Deskripsi": "Cluster dengan desain tropis kontemporer, dilengkapi fasilitas umum yang mendukung kenyamanan penghuni.",
                "Detail Rumah": "-",
                "Developer": "Summarecon",
                "Bank yang Bekerjasama": "BCA",
                "Image Path": r"C:\Users\arche\0(python VISUAL STUDIO CODE)\Property\8.jpg"
            },
            {
                "Nama": "Summarecon Mutiara Makassar - Green Crystal",
                "Harga": "Mulai Rp 2 miliar (termasuk PPN dan BPHTB)",
                "Lokasi": "Summarecon Mutiara Makassar,Biring Kanaya, Makassar",
                "Deskripsi": "Cluster dengan fasilitas modern, menawarkan kenyamanan dan kemewahan bagi penghuninya.",
                "Detail Rumah": "-",
                "Developer": "Summarecon",
                "Bank yang Bekerjasama": "BCA",
                "Image Path": r"C:\Users\arche\0(python VISUAL STUDIO CODE)\Property\9.jpg"
            },
            {
                "Nama": "Summarecon Mutiara Makassar - The Morizen Makassar",
                "Harga": "Mulai Rp 10 miliar (termasuk PPN dan BPHTB)",
                "Lokasi": "Summarecon Mutiara Makassar,Biring Kanaya, Makassar",
                "Deskripsi": "Hunian dengan konsep Jepang, menawarkan keseimbangan antara elegansi dan kenyamanan.",
                "Detail Rumah": "-",
                "Developer": "Summarecon",
                "Bank yang Bekerjasama": "BCA",
                "Image Path": r"C:\Users\arche\0(python VISUAL STUDIO CODE)\Property\10.jpg"
            },
            {
                "Nama": "Summarecon Mutiara Makassar - Ruko Graha Boulevard Makassar",
                "Harga": "Mulai Rp 1,5 miliar (termasuk PPN dan BPHTB)",
                "Lokasi": "Summarecon Mutiara Makassar,Biring Kanaya, Makassar",
                "Deskripsi": "Ruko 3 lantai dengan lokasi strategis, cocok untuk berbagai jenis usaha. ",
                "Detail Rumah": "Luas bangunan 115 m², 1 kamar mandi",
                "Developer": "Summarecon",
                "Bank yang Bekerjasama": "BCA",
                "Image Path": r"C:\Users\arche\0(python VISUAL STUDIO CODE)\Property\11.jpg"
            },






            {
                "Nama": "Virginia Park Makassar",
                "Harga": "Mulai Rp 1.000.000.000 hingga Rp 2.000.000.000",
                "Lokasi": "Biring Kanaya, Makassar",
                "Deskripsi": "Perumahan mewah dengan konsep Luxury Home with Green Development Concept, menawarkan hunian mewah dengan lingkungan hijau yang nyaman.",
                "Detail Rumah": "-",
                "Developer": "Brighton Real Estate",
                "Bank yang Bekerjasama": "-",
                "Image Path": r"C:\Users\arche\0(python VISUAL STUDIO CODE)\Property\12.jpg"
            },
             {
                "Nama": "Perumahan Grand Barombong",
                "Harga": "Rp 177.000.000",
                "Lokasi": "Makassar",
                "Deskripsi": "Rumah tinggal 1 lantai dengan lokasi strategis dan harga terjangkau.",
                "Detail Rumah": "Luas tanah 72 m², luas bangunan 36 m².",
                "Developer": "-",
                "Bank yang Bekerjasama": "-",
                "Image Path": r"C:\Users\arche\0(python VISUAL STUDIO CODE)\Property\13.jpg"
            },
             {
                "Nama": "Royal Sentraland BTP Makassar",
                "Harga": "Rp 330.000.000",
                "Lokasi": "Makassar",
                "Deskripsi": "Rumah tinggal 2 lantai dengan 3 kamar tidur dan 3 kamar mandi.",
                "Detail Rumah": "Luas tanah 84 m², luas bangunan 84 m².",
                "Developer": "-",
                "Bank yang Bekerjasama": "-",
                "Image Path": r"C:\Users\arche\0(python VISUAL STUDIO CODE)\Property\14.jpg"
            },
            {
                "Nama": "Rumah Tengah Kota Makassar",
                "Harga": "Mulai Rp 588.000.000",
                "Lokasi": "Makassar",
                "Deskripsi": "Rumah tersedia dalam 2 tipe, 1 dan 2 lantai, dengan opsi cicilan developer maksimal 3 tahun tanpa bank dan tanpa bunga.",
                "Detail Rumah": "-",
                "Developer": "Rajata",
                "Bank yang Bekerjasama": "-",
                "Image Path": r"C:\Users\arche\0(python VISUAL STUDIO CODE)\Property\15.jpg"
            },
             {
                "Nama": "Perumahan Green Residence Sudiang",
                "Harga": "Mulai Rp 700.000.000",
                "Lokasi": "Sudiang, Makassar",
                "Deskripsi": " Kawasan ramah lingkungan dengan fasilitas taman hijau dan sistem cluster.",
                "Detail Rumah": "Rumah 1 lantai, 2 kamar tidur, 1 kamar mandi, luas tanah 72 m².",
                "Developer": "GreenLand Developer",
                "Bank yang Bekerjasama": "Bank Mandiri, BNI",
                "Image Path": r"C:\Users\arche\0(python VISUAL STUDIO CODE)\Property\16.jpg"
            },
            {
                "Nama": "Perumahan Taman Sari Makassar",
                "Harga": "Mulai Rp 1.200.000.000",
                "Lokasi": "Tamalanrea, Makassar",
                "Deskripsi": "Perumahan dengan konsep modern minimalis, dilengkapi dengan fasilitas keamanan 24 jam dan taman bermain anak.",
                "Detail Rumah": "Rumah 2 lantai, 3 kamar tidur, 2 kamar mandi, luas tanah 90 m².",
                "Developer": "PT. Taman Sari Makassar",
                "Bank yang Bekerjasama": "BCA, BRI",
                "Image Path": r"C:\Users\arche\0(python VISUAL STUDIO CODE)\Property\17.jpg"
            },
             {
                "Nama": "Perumahan Bukit Baruga Antang",
                "Harga": "Mulai Rp 900.000.000",
                "Lokasi": "Antang, Makassar",
                "Deskripsi": "Perumahan dengan lingkungan asri,",
                "Detail Rumah": "-",
                "Developer": "Bukit Baruga",
                "Bank yang Bekerjasama": "BCA",
                "Image Path": r"C:\Users\arche\0(python VISUAL STUDIO CODE)\Property\18.jpg"
            },
             
            
        ]

        for property in properties:
            # Create a frame for each property
            property_frame = ctk.CTkFrame(scrollable_frame)
            property_frame.pack(fill='x', padx=5, pady=5)
            img_path = property.get("Image Path")
            # Load and display the property image
            img_path = property["Image Path"]
            if img_path:  # Check if img_path is not None
                img = Image.open(img_path)
                img = img.resize((400, 400), Image.LANCZOS)  # Resize as needed
                img_photo = ImageTk.PhotoImage(img)

        # Create labels for the image and text
                image_label = ctk.CTkLabel(property_frame, image=img_photo)
                image_label.image = img_photo  # Keep a reference to avoid garbage collection
                image_label.grid(row=0, column=0, padx=10)

            # Create a frame for text information
            text_frame = ctk.CTkFrame(property_frame)
            text_frame.grid(row=0, column=1, padx=10)

            # Add property details to the text frame
            ctk.CTkLabel(text_frame, text="Nama: ", font=("Arial", 14)).grid(row=0, column=0, sticky="w")
            ctk.CTkLabel(text_frame, text=property["Nama"], font=("Arial", 14)).grid(row=0, column=1, sticky="w")

            ctk.CTkLabel(text_frame, text="Harga: ", font=("Arial", 14)).grid(row=1, column=0, sticky="w")
            ctk.CTkLabel(text_frame, text=property["Harga"], font=("Arial", 14)).grid(row=1, column=1, sticky="w")

            ctk.CTkLabel(text_frame, text="Lokasi: ", font=("Arial", 14)).grid(row=2, column=0, sticky="w")
            ctk.CTkLabel(text_frame, text=property["Lokasi"], font=("Arial", 14)).grid(row=2, column=1, sticky="w")

            ctk.CTkLabel(text_frame, text="Deskripsi: ", font=("Arial", 14)).grid(row=3, column=0, sticky="w")
            ctk.CTkLabel(text_frame, text=property["Deskripsi"], font=("Arial", 12), text_color="gray").grid(row=3, column=1, sticky="w")

            ctk.CTkLabel(text_frame, text="Detail Rumah: ", font=("Arial", 14)).grid(row=4, column=0, sticky="w")
            ctk.CTkLabel(text_frame, text=property["Detail Rumah"], font=("Arial", 12), text_color="gray").grid(row=4, column=1, sticky="w")

            ctk.CTkLabel(text_frame, text="Developer: ", font=("Arial", 14)).grid(row=5, column=0, sticky="w")
            ctk.CTkLabel(text_frame, text=property["Developer"], font=("Arial", 12), text_color="gray").grid(row=5, column=1, sticky="w")

            ctk.CTkLabel(text_frame, text="Bank yang Bekerjasama: ", font=("Arial", 14)).grid(row=6, column=0, sticky="w")
            ctk.CTkLabel(text_frame, text=property["Bank yang Bekerjasama"], font=("Arial", 12), text_color="gray").grid(row=6, column=1, sticky="w")
        # Back button to return to the dashboard
         # Back button to return to the dashboard
        ctk.CTkButton(self, text="Kembali ke Dashboard", command=lambda: controller.show_frame("BuyerDashboardFrame")).pack(pady=10)

















































class DeveloperDashboardFrame(ctk.CTkFrame):
    def __init__(self, parent, controller):
        super().__init__(parent)
        self.controller = controller

        # Create a scrollable frame
        scrollable_frame = ctk.CTkScrollableFrame(self)
        scrollable_frame.pack(expand=True, fill="both", padx=20, pady=20)

        ctk.CTkLabel(scrollable_frame, text="Selamat Datang di Dashboard Developer/Owner", font=("Arial", 24)).pack(pady=20)


        # List of logo images for the slideshow
        self.logo_images = [
            r"C:\\Users\\arche\\0(python VISUAL STUDIO CODE)\\Property\\1.jpg",
            r"C:\\Users\\arche\\0(python VISUAL STUDIO CODE)\\Property\\2.jpg",
            r"C:\\Users\\arche\\0(python VISUAL STUDIO CODE)\\Property\\3.jpg",
            r"C:\\Users\\arche\\0(python VISUAL STUDIO CODE)\\Property\\4.jpg",
            r"C:\\Users\\arche\\0(python VISUAL STUDIO CODE)\\Property\\5.jpg",
            r"C:\\Users\\arche\\0(python VISUAL STUDIO CODE)\\Property\\6.jpg",
            r"C:\\Users\\arche\\0(python VISUAL STUDIO CODE)\\Property\\7.jpg",
            r"C:\\Users\\arche\\0(python VISUAL STUDIO CODE)\\Property\\8.jpg",
            r"C:\\Users\\arche\\0(python VISUAL STUDIO CODE)\\Property\\9.jpg",
            r"C:\\Users\\arche\\0(python VISUAL STUDIO CODE)\\Property\\10.jpg",
            r"C:\\Users\\arche\\0(python VISUAL STUDIO CODE)\\Property\\11.jpg",
            r"C:\\Users\\arche\\0(python VISUAL STUDIO CODE)\\Property\\12.jpg",
            r"C:\\Users\\arche\\0(python VISUAL STUDIO CODE)\\Property\\13.jpg"
        ]
        
        self.current_image_index = 0  # Start with the first image
        self.logo_label = ctk.CTkLabel(scrollable_frame)
        self.logo_label.pack(pady=10)

        # Load the first logo image
        self.update_logo()

        # Start the slideshow
        self.after(3000, self.slideshow)  # Change image every 3 seconds





        # Menu Options
        ctk.CTkButton(scrollable_frame, text="Informasi Anda", command=self.show_user_info , width=250).pack(pady=10)
        ctk.CTkButton(scrollable_frame, text="Edit Informasi Anda", command=self.edit_user_info , width=250).pack(pady=10)
        
        # Property Management Section
        ctk.CTkLabel(scrollable_frame, text="Kelola Properti", font=("Arial", 18)).pack(pady=10)
        ctk.CTkButton(scrollable_frame, text="Daftar Properti", command=self.show_property_list , width=250).pack(pady=5)
        ctk.CTkButton(scrollable_frame, text="Tambah Properti", command=self.add_property , width=250).pack(pady=5)
        ctk.CTkButton(scrollable_frame, text="Hapus Properti", command=self.edit_property , width=250).pack(pady=5)

        # Sales Statistics
        ctk.CTkButton(scrollable_frame, text="Lihat Statistik Penjualan", command=lambda: controller.show_frame("SalesStatisticsFrame") , width=250).pack(pady=10)

        # Logout
        ctk.CTkButton(scrollable_frame, text="Log Out", command=lambda: controller.show_frame("BLogoutFrame") , width=150).pack(pady=50)


        self.footer_frame = ctk.CTkFrame(self)
        self.footer_frame.pack(side='bottom', fill='x', padx=(10, 10), pady=(10, 10))

        # Add copyright label
        copyright_label = ctk.CTkLabel(self.footer_frame, text="Copyright © 2025 NNG Property by nayrbryanGaming Official. All rights reserved.", font=("Arial", 10))
        copyright_label.pack(side='top', pady=(0, 5))  # Place at the top of the footer

        # Add social media links
        self.add_social_media_links()

    def add_social_media_links(self):
        """Load and display social media links."""
        social_media = {
            "Website": "https://nayrbryangaming.wixsite.com/nng-store",
            "TikTok": "https://www.tiktok.com/@nng_store?_t=8sdywlIzjIg&_r=1",
            "Facebook": "https://www.facebook.com/profile.php?id=61567061512465",
            "Instagram": "https://www.instagram.com/nngstoreofficial/profilecard/?igsh=cjI5eWFxMGFnd2Jz",
            "YouTube": "https://www.youtube.com/@NNGStore",
            # Add more platforms as needed
        }

        social_media_frame = ctk.CTkFrame(self.footer_frame)  # Create a frame for social media links
        social_media_frame.pack(side='top')  # Pack it below the copyright label

        for platform, url in social_media.items():
            link_label = ctk.CTkLabel(social_media_frame, text=platform, font=("Arial", 10), text_color="White", cursor="hand2")
            link_label.pack(side='left', padx=(5, 5))
            link_label.bind("<Button-1>", lambda e, url=url: webbrowser.open(url))  # Bind click event to open URL






        # Back to Login
        
    def show_user_info(self):
        """Show user information."""
        self.controller.show_frame("UserInfoFrame")  # Open User Info Frame

    def edit_user_info(self):
        """Edit user information."""
        self.controller.show_frame("EditUserInfoFrame")  # Open Edit User Info Frame

    def show_property_list(self):
        """Show the list of properties."""
        self.controller.show_frame("PropertyListFrame")  # Open Property List Frame

    def add_property(self):
        """Add a new property."""
        self.controller.show_frame("AddPropertyFrame")  # Open Add Property Frame

    def edit_property(self):
        """Edit or delete a property."""
        self.controller.show_frame("EditPropertyFrame")  # Open Edit Property Frame




    def update_logo(self):
        """Load and display the current logo image with error handling."""
        logo_path = self.logo_images[self.current_image_index]

        try:
            # Check if the file exists before trying to open it
            if not os.path.exists(logo_path):
                raise FileNotFoundError(f"File not found: {logo_path}")
            
            logo_image = Image.open(logo_path)
            logo_image = logo_image.resize((300, 300), Image.LANCZOS)  # Resize if needed
            self.logo_photo = ImageTk.PhotoImage(logo_image)

            # Update the label with the new image
            self.logo_label.configure(image=self.logo_photo)

        except Exception as e:
            print(f"Error loading image: {e}")
            # Optionally set a default image or handle the error accordingly

        
    def slideshow(self):
        """Change to the next logo image in the slideshow."""
        # Update index to show next image
        self.current_image_index = (self.current_image_index + 1) % len(self.logo_images)
        
        # Update the logo displayed in the label
        self.update_logo()
        
        # Schedule the next slideshow update
        self.after(3000, self.slideshow)  # Change image every 3 seconds





















# Example User Info Frame
class UserInfoFrame(ctk.CTkFrame):
    def __init__(self, parent, controller):
        super().__init__(parent)
        self.controller = controller
        
        scrollable_frame = ctk.CTkScrollableFrame(self)
        scrollable_frame.pack(expand=True, fill="both", padx=20, pady=20)

        ctk.CTkLabel(scrollable_frame, text="Biodata Lengkap", font=("Arial", 24)).pack(pady=20)

        profile_image_path = r"C:\\Users\\arche\\0(python VISUAL STUDIO CODE)\\Property\\you (2).jpg"  # Update with your actual image path
        self.profile_image = self.create_circular_image(profile_image_path, size=(500, 500))

        # Display profile image
        self.profile_photo = ImageTk.PhotoImage(self.profile_image)
        profile_label = ctk.CTkLabel(scrollable_frame, image=self.profile_photo)
        profile_label.pack(pady=10)




        # Dummy profile information for demonstration
        profile_info = {
            "Nama Panggilan": "Vin",
            "Nama Lengkap": "Vincentius Bryan Kwandou",
            "NIK": "7371091708000009",
            "Tempat Lahir": "Jayapura",
            "Tanggal Lahir": "17/08/2000",
            "Status Kewarganegaraan": "WNI",
            "Jenis Kelamin": "Pria",
            "Status Perkawinan": "Belum Menikah",
            "Golongan Darah": "O",
            "Rhesus": "Positif",
            "Pekerjaan": "Konten Kreator TikTok",
            "Lama Bekerja": "Lebih Dari 10 Tahun",
            "Alamat Tempat Kerja": "Jl. Urip No.5",
            "Alamat": "Jl. Urip No.5",
            "Nomor Telepon": "082293212721",
            "Penghasilan Per Bulan": "Rp 6.000.000",
            "Status BI Checking": "Kolektibilitas 1",
            "Jumlah Tabungan Saat Ini": "< Rp 50.000.000,-"
        }

        # Add each profile information label to the scrollable frame
        for label_text, info in profile_info.items():
            entry_frame = ctk.CTkFrame(scrollable_frame)
            entry_frame.pack(fill='x', pady=5)

            label = ctk.CTkLabel(entry_frame, text=f"{label_text}: {info}", font=("Arial", 10), anchor='w')
            label.pack(side='left', padx=(0, 10), fill='x')

        ctk.CTkButton(self, text="Kembali ke Dashboard", command=lambda: controller.show_frame("DeveloperDashboardFrame")).pack(pady=20)



    def create_circular_image(self, path, size=(700, 700)):
        """Create a circular image from a given path."""
        img = Image.open(path).convert("RGBA")
        img = img.resize(size, Image.LANCZOS)

        # Create a circular mask
        mask = Image.new("L", size, 0)
        draw = ImageDraw.Draw(mask)
        draw.ellipse((0, 0) + size, fill=255)

        # Apply mask to the image
        circular_img = Image.new("RGBA", size)
        circular_img.paste(img, (0, 0), mask)

        return circular_img



        
        ctk.CTkButton(self, text="Kembali ke Dashboard", command=lambda: controller.show_frame("DeveloperDashboardFrame")).pack(pady=20)





















# Example Edit User Info Frame
class EditUserInfoFrame(ctk.CTkFrame):
    def __init__(self, parent, controller):
        super().__init__(parent)
        self.controller = controller
        
        scrollable_frame = ctk.CTkScrollableFrame(self)
        scrollable_frame.pack(expand=True, fill="both", padx=20, pady=20)

        ctk.CTkLabel(scrollable_frame, text="Edit Profile", font=("Arial", 24)).pack(pady=20)

 
        # Entry fields for profile details
        self.name_entry = ctk.CTkEntry(scrollable_frame, placeholder_text="Nama Lengkap")
        self.name_entry.pack(pady=10)

        self.email_entry = ctk.CTkEntry(scrollable_frame, placeholder_text="Email")
        self.email_entry.pack(pady=10)

        self.phone_entry = ctk.CTkEntry(scrollable_frame, placeholder_text="Nomor Telepon")
        self.phone_entry.pack(pady=10)

         # Date of Birth using tkcalendar DateEntry
        ctk.CTkLabel(scrollable_frame, text="Tanggal Lahir").pack(pady=(0))
        self.dob_entry = DateEntry(scrollable_frame, width=30)
        self.dob_entry.pack(pady=0)


# Dropdowns with labels for other attributes
        nationality_options = ["WNI", "WNA", "Kewarganegaraan Ganda", "Tanpa Kewarganegaraan"]
        gender_options = ["Pria", "Wanita"]
        marital_status_options = ["Belum Menikah", "Sudah Menikah"]
        blood_type_options = ["A", "B", "AB", "O"]
        rhesus_options = ["Positif", "Negatif"]
        work_duration_options = ["Kurang dari 1 Tahun", "1-3 Tahun", "3-5 Tahun", "5-10 Tahun", "Lebih Dari 10 Tahun"]
        income_options = ["<Rp 3.000.000", "Rp 3.000.000 - Rp 5.999.999", "Rp 6.000.000 - Rp 9.999.999", "Rp 10.000.000 - Rp 19.999.999", "Rp 20.000.000 - Rp 34.999.999" , "Rp 35.000.000 - Rp 50.000.000","> Rp 60.000.000"]
        bi_status_options = ["Kolektibilitas 1", "Kolektibilitas 2", "Kolektibilitas 3", "Kolektibilitas 4", "Kolektibilitas 5"]
        savings_options = ["< Rp 50.000.000", "Rp 50.000.000 - Rp 99.999.999","Rp 100.000.000 - Rp 499.999.999", "Rp 500.000.000 - Rp 999.999.999", "Rp 1.000.000.000 - Rp 10.000.000.000", "> Rp 10.000.000.000"]

         # Dropdowns with corresponding labels
        ctk.CTkLabel(scrollable_frame, text="Kewarganegaraan").pack(pady=(0))
        ctk.CTkOptionMenu(scrollable_frame, values=nationality_options).pack(pady=(5))

        ctk.CTkLabel(scrollable_frame, text="Jenis Kelamin").pack(pady=(0))
        ctk.CTkOptionMenu(scrollable_frame, values=gender_options).pack(pady=(5))

        ctk.CTkLabel(scrollable_frame, text="Status Perkawinan").pack(pady=(0))
        ctk.CTkOptionMenu(scrollable_frame, values=marital_status_options).pack(pady=(5))

        ctk.CTkLabel(scrollable_frame, text="Golongan Darah").pack(pady=(0))
        ctk.CTkOptionMenu(scrollable_frame, values=blood_type_options).pack(pady=(5))

        ctk.CTkLabel(scrollable_frame, text="Rhesus").pack(pady=(0))
        ctk.CTkOptionMenu(scrollable_frame, values=rhesus_options).pack(pady=(5))

        ctk.CTkLabel(scrollable_frame, text="Lama Bekerja").pack(pady=(0))
        ctk.CTkOptionMenu(scrollable_frame, values=work_duration_options).pack(pady=(5))

        ctk.CTkLabel(scrollable_frame, text="Penghasilan Per Bulan").pack(pady=(0))
        ctk.CTkOptionMenu(scrollable_frame, values=income_options).pack(pady=(5))

        ctk.CTkLabel(scrollable_frame, text="Status BI Checking").pack(pady=(0))
        ctk.CTkOptionMenu(scrollable_frame, values=bi_status_options).pack(pady=(5))

        ctk.CTkLabel(scrollable_frame, text="Jumlah Tabungan Saat Ini").pack(pady=(0))
        ctk.CTkOptionMenu(scrollable_frame, values=savings_options).pack(pady=(5))


        ctk.CTkButton(self, text="Simpan Perubahan", command=self.save_changes).pack(pady=40)

    def save_changes(self):
        full_name = self.name_entry.get()
        email = self.email_entry.get()
        phone_number = self.phone_entry.get()

        print(f"Profile Updated: Name: {full_name}, Email: {email}, Phone: {phone_number}")

         # Clear entry fields after saving.
        self.name_entry.delete(0, 'end')
        self.email_entry.delete(0, 'end')
        self.phone_entry.delete(0, 'end')

         # Optionally navigate back to the dashboard.
        self.controller.show_frame("DeveloperDashboardFrame")




























class SalesStatisticsFrame(ctk.CTkFrame):
    def __init__(self, parent, controller):
        super().__init__(parent)
        self.controller = controller

        scrollable_frame = ctk.CTkScrollableFrame(self)
        scrollable_frame.pack(expand=True, fill="both", padx=20, pady=20)

        ctk.CTkLabel(scrollable_frame, text="Statistik Penjualan", font=("Arial", 24)).pack(pady=20)

        ctk.CTkButton(scrollable_frame, text="Kembali ke Dashboard", command=lambda: controller.show_frame("DeveloperDashboardFrame")).pack(pady=10)




























class EditPropertyFrame(ctk.CTkFrame):
    def __init__(self, parent, controller):
        super().__init__(parent)
        self.controller = controller

    
        ctk.CTkLabel(self, text="Properti yang anda sudah daftarkan", font=("Arial", 24)).pack(pady=20)

        scrollable_frame = ctk.CTkScrollableFrame(self)
        scrollable_frame.pack(expand=True, fill="both", padx=20, pady=20)

        # Dummy property list with details
        properties = [
            {
                "Nama": "CitraLand City CPI Makassar - Golden Avenue",
                "Harga": "Mulai Rp 5.000.000.000",
                "Lokasi": "Mariso, Makassar",
                "Deskripsi": "Rumah 2 lantai dengan desain modern, luas bangunan 166 m², dan luas tanah 162 m²",
                "Detail Rumah": "3+1 kamar tidur, 4 kamar mandi, garasi untuk 1 mobil, daya listrik 3300 Watt, sumber air PAM, dan fitur smart home.",
                "Developer": "Ciputra",
                "Bank yang Bekerjasama": "BCA",
                "Image Path": r"C:\\Users\\arche\\0(python VISUAL STUDIO CODE)\\Property\\1.jpg"
            },





            {
                "Nama": "Summarecon Mutiara Makassar - Cluster Akasia",
                "Harga": "Mulai Rp 1.100.000.000 hingga Rp 2.100.000.000",
                "Lokasi": "Summarecon Mutiara Makassar, Biring Kanaya, Makassar",
                "Deskripsi": "Perumahan dengan konsep Aeroport City, dikembangkan di atas lahan seluas 400 hektar, dekat dengan bandara dan pelabuhan baru, serta memiliki akses tol langsung.",
                "Detail Rumah": "Beragam tipe rumah dengan fasilitas kolam renang, area bermain, ruang komunitas, lapangan basket, taman hijau, keamanan 24 jam, dan sekolah.",
                "Developer": "Summarecon",
                "Bank yang Bekerjasama": "BCA",
                "Image Path": r"C:\\Users\\arche\\0(python VISUAL STUDIO CODE)\\Property\\2.jpg"
            
            },
            {
                "Nama": "Summarecon Mutiara Makassar - Jade Residence",
                "Harga": "Mulai Rp 1.100.000.000",
                "Lokasi": "Summarecon Mutiara Makassar, Biring Kanaya, Makassar",
                "Deskripsi": "Hunian mewah dengan sentuhan gaya klasik yang mewakili kemapanan dan keanggunan dengan detail arsitektur yang kaya.",
                "Detail Rumah": "Beragam tipe rumah dengan fasilitas kolam renang, area bermain, ruang komunitas, lapangan basket, taman hijau, keamanan 24 jam, dan sekolah.",
                "Developer": "Summarecon",
                "Bank yang Bekerjasama": "BCA",
                "Image Path": r"C:\\Users\\arche\\0(python VISUAL STUDIO CODE)\\Property\\3.jpg"
            },
            {
                "Nama": "Summarecon Mutiara Makassar - Jade 2 Residence",
                "Harga": "Mulai Rp 2,2 miliar (termasuk PPN dan BPHTB)",
                "Lokasi": "Summarecon Mutiara Makassar,Biring Kanaya, Makassar",
                "Deskripsi": "Properti dengan desain modern klasik, menawarkan kenyamanan dan kemewahan bagi penghuninya.",
                "Detail Rumah": "-",
                "Developer": "Summarecon",
                "Bank yang Bekerjasama": "BCA",
                "Image Path": r"C:\Users\arche\0(python VISUAL STUDIO CODE)\Property\4.jpg"
            },
            {
                "Nama": "Summarecon Mutiara Makassar - The Topaz Residence",
                "Harga": "Mulai Rp 2,1 miliar (termasuk PPN dan BPHTB)",
                "Lokasi": "Summarecon Mutiara Makassar,Biring Kanaya, Makassar",
                "Deskripsi": "Cluster dengan desain modern, menawarkan kenyamanan bagi penghuninya.",
                "Detail Rumah": "-",
                "Developer": "Summarecon",
                "Bank yang Bekerjasama": "BCA",
                "Image Path": r"C:\Users\arche\0(python VISUAL STUDIO CODE)\Property\5.jpg"
            },
            {
                "Nama": "Summarecon Mutiara Makassar - The Topaz Residence Type Sherry",
                "Harga": "Mulai Rp 2,5 miliar (termasuk PPN dan BPHTB)",
                "Lokasi": "Summarecon Mutiara Makassar,Biring Kanaya, Makassar",
                "Deskripsi": "Hunian dengan desain modern yang memukau, menggabungkan elegansi dan kenyamanan.",
                "Detail Rumah": "-",
                "Developer": "Summarecon",
                "Bank yang Bekerjasama": "BCA",
                "Image Path": r"C:\Users\arche\0(python VISUAL STUDIO CODE)\Property\6.jpg"
            },
            {
                "Nama": "Summarecon Mutiara Makassar - Beryl Residence",
                "Harga": "Mulai Rp 1,2 miliar (termasuk PPN dan BPHTB)",
                "Lokasi": "Summarecon Mutiara Makassar,Biring Kanaya, Makassar",
                "Deskripsi": "Cluster dengan fasilitas umum seperti kolam renang, clubhouse, dan area bermain anak.",
                "Detail Rumah": "-",
                "Developer": "Summarecon",
                "Bank yang Bekerjasama": "BCA",
                "Image Path": r"C:\Users\arche\0(python VISUAL STUDIO CODE)\Property\7.jpg"
            },
            {
                "Nama": "Summarecon Mutiara Makassar - Blue Crystal",
                "Harga": "Mulai Rp 2 miliar (termasuk PPN dan BPHTB)",
                "Lokasi": "Summarecon Mutiara Makassar,Biring Kanaya, Makassar",
                "Deskripsi": "Cluster dengan desain tropis kontemporer, dilengkapi fasilitas umum yang mendukung kenyamanan penghuni.",
                "Detail Rumah": "-",
                "Developer": "Summarecon",
                "Bank yang Bekerjasama": "BCA",
                "Image Path": r"C:\Users\arche\0(python VISUAL STUDIO CODE)\Property\8.jpg"
            },
            {
                "Nama": "Summarecon Mutiara Makassar - Green Crystal",
                "Harga": "Mulai Rp 2 miliar (termasuk PPN dan BPHTB)",
                "Lokasi": "Summarecon Mutiara Makassar,Biring Kanaya, Makassar",
                "Deskripsi": "Cluster dengan fasilitas modern, menawarkan kenyamanan dan kemewahan bagi penghuninya.",
                "Detail Rumah": "-",
                "Developer": "Summarecon",
                "Bank yang Bekerjasama": "BCA",
                "Image Path": r"C:\Users\arche\0(python VISUAL STUDIO CODE)\Property\9.jpg"
            },
            {
                "Nama": "Summarecon Mutiara Makassar - The Morizen Makassar",
                "Harga": "Mulai Rp 10 miliar (termasuk PPN dan BPHTB)",
                "Lokasi": "Summarecon Mutiara Makassar,Biring Kanaya, Makassar",
                "Deskripsi": "Hunian dengan konsep Jepang, menawarkan keseimbangan antara elegansi dan kenyamanan.",
                "Detail Rumah": "-",
                "Developer": "Summarecon",
                "Bank yang Bekerjasama": "BCA",
                "Image Path": r"C:\Users\arche\0(python VISUAL STUDIO CODE)\Property\10.jpg"
            },
            {
                "Nama": "Summarecon Mutiara Makassar - Ruko Graha Boulevard Makassar",
                "Harga": "Mulai Rp 1,5 miliar (termasuk PPN dan BPHTB)",
                "Lokasi": "Summarecon Mutiara Makassar,Biring Kanaya, Makassar",
                "Deskripsi": "Ruko 3 lantai dengan lokasi strategis, cocok untuk berbagai jenis usaha. ",
                "Detail Rumah": "Luas bangunan 115 m², 1 kamar mandi",
                "Developer": "Summarecon",
                "Bank yang Bekerjasama": "BCA",
                "Image Path": r"C:\Users\arche\0(python VISUAL STUDIO CODE)\Property\11.jpg"
            },






            {
                "Nama": "Virginia Park Makassar",
                "Harga": "Mulai Rp 1.000.000.000 hingga Rp 2.000.000.000",
                "Lokasi": "Biring Kanaya, Makassar",
                "Deskripsi": "Perumahan mewah dengan konsep Luxury Home with Green Development Concept, menawarkan hunian mewah dengan lingkungan hijau yang nyaman.",
                "Detail Rumah": "-",
                "Developer": "Brighton Real Estate",
                "Bank yang Bekerjasama": "-",
                "Image Path": r"C:\Users\arche\0(python VISUAL STUDIO CODE)\Property\12.jpg"
            },
             {
                "Nama": "Perumahan Grand Barombong",
                "Harga": "Rp 177.000.000",
                "Lokasi": "Makassar",
                "Deskripsi": "Rumah tinggal 1 lantai dengan lokasi strategis dan harga terjangkau.",
                "Detail Rumah": "Luas tanah 72 m², luas bangunan 36 m².",
                "Developer": "-",
                "Bank yang Bekerjasama": "-",
                "Image Path": r"C:\Users\arche\0(python VISUAL STUDIO CODE)\Property\13.jpg"
            },
             {
                "Nama": "Royal Sentraland BTP Makassar",
                "Harga": "Rp 330.000.000",
                "Lokasi": "Makassar",
                "Deskripsi": "Rumah tinggal 2 lantai dengan 3 kamar tidur dan 3 kamar mandi.",
                "Detail Rumah": "Luas tanah 84 m², luas bangunan 84 m².",
                "Developer": "-",
                "Bank yang Bekerjasama": "-",
                "Image Path": r"C:\Users\arche\0(python VISUAL STUDIO CODE)\Property\14.jpg"
            },
            {
                "Nama": "Rumah Tengah Kota Makassar",
                "Harga": "Mulai Rp 588.000.000",
                "Lokasi": "Makassar",
                "Deskripsi": "Rumah tersedia dalam 2 tipe, 1 dan 2 lantai, dengan opsi cicilan developer maksimal 3 tahun tanpa bank dan tanpa bunga.",
                "Detail Rumah": "-",
                "Developer": "Rajata",
                "Bank yang Bekerjasama": "-",
                "Image Path": r"C:\Users\arche\0(python VISUAL STUDIO CODE)\Property\15.jpg"
            },
             {
                "Nama": "Perumahan Green Residence Sudiang",
                "Harga": "Mulai Rp 700.000.000",
                "Lokasi": "Sudiang, Makassar",
                "Deskripsi": " Kawasan ramah lingkungan dengan fasilitas taman hijau dan sistem cluster.",
                "Detail Rumah": "Rumah 1 lantai, 2 kamar tidur, 1 kamar mandi, luas tanah 72 m².",
                "Developer": "GreenLand Developer",
                "Bank yang Bekerjasama": "Bank Mandiri, BNI",
                "Image Path": r"C:\Users\arche\0(python VISUAL STUDIO CODE)\Property\16.jpg"
            },
            {
                "Nama": "Perumahan Taman Sari Makassar",
                "Harga": "Mulai Rp 1.200.000.000",
                "Lokasi": "Tamalanrea, Makassar",
                "Deskripsi": "Perumahan dengan konsep modern minimalis, dilengkapi dengan fasilitas keamanan 24 jam dan taman bermain anak.",
                "Detail Rumah": "Rumah 2 lantai, 3 kamar tidur, 2 kamar mandi, luas tanah 90 m².",
                "Developer": "PT. Taman Sari Makassar",
                "Bank yang Bekerjasama": "BCA, BRI",
                "Image Path": r"C:\Users\arche\0(python VISUAL STUDIO CODE)\Property\17.jpg"
            },
            
             {
                "Nama": "Perumahan Bukit Baruga Antang",
                "Harga": "Mulai Rp 900.000.000",
                "Lokasi": "Antang, Makassar",
                "Deskripsi": "Perumahan dengan lingkungan asri,",
                "Detail Rumah": "-",
                "Developer": "Bukit Baruga",
                "Bank yang Bekerjasama": "BCA",
                "Image Path": r"C:\Users\arche\0(python VISUAL STUDIO CODE)\Property\18.jpg"
            },
             
            
        ]
        self.checkboxes = []  # List to hold checkbox variables

        for property in properties:
            # Create a frame for each property
            property_frame = ctk.CTkFrame(scrollable_frame)
            property_frame.pack(fill='x', padx=5, pady=5)



            checkbox_var = ctk.IntVar()  # Variabel untuk menyimpan status checkbox
            checkbox = ctk.CTkCheckBox(property_frame, variable=checkbox_var)
            checkbox.grid(row=0, column=0, padx=10)
            self.checkboxes.append((checkbox_var, property_frame))  # Simpan variabel dan frame

            img_path = property.get("Image Path")
            # Load and display the property image
            img_path = property["Image Path"]
            if img_path:  # Check if img_path is not None
                img = Image.open(img_path)
                img = img.resize((400, 400), Image.LANCZOS)  # Resize as needed
                img_photo = ImageTk.PhotoImage(img)

        # Create labels for the image and text
                image_label = ctk.CTkLabel(property_frame, image=img_photo)
                image_label.image = img_photo  # Keep a reference to avoid garbage collection
                image_label.grid(row=0, column=1, padx=10)

            # Create a frame for text information
            text_frame = ctk.CTkFrame(property_frame)
            text_frame.grid(row=0, column=2, padx=10)

            # Add property details to the text frame
            ctk.CTkLabel(text_frame, text="Nama: ", font=("Arial", 14)).grid(row=0, column=0, sticky="w")
            ctk.CTkLabel(text_frame, text=property["Nama"], font=("Arial", 14)).grid(row=0, column=1, sticky="w")

            ctk.CTkLabel(text_frame, text="Harga: ", font=("Arial", 14)).grid(row=1, column=0, sticky="w")
            ctk.CTkLabel(text_frame, text=property["Harga"], font=("Arial", 14)).grid(row=1, column=1, sticky="w")

            ctk.CTkLabel(text_frame, text="Lokasi: ", font=("Arial", 14)).grid(row=2, column=0, sticky="w")
            ctk.CTkLabel(text_frame, text=property["Lokasi"], font=("Arial", 14)).grid(row=2, column=1, sticky="w")

            ctk.CTkLabel(text_frame, text="Deskripsi: ", font=("Arial", 14)).grid(row=3, column=0, sticky="w")
            ctk.CTkLabel(text_frame, text=property["Deskripsi"], font=("Arial", 12), text_color="gray").grid(row=3, column=1, sticky="w")

            ctk.CTkLabel(text_frame, text="Detail Rumah: ", font=("Arial", 14)).grid(row=4, column=0, sticky="w")
            ctk.CTkLabel(text_frame, text=property["Detail Rumah"], font=("Arial", 12), text_color="gray").grid(row=4, column=1, sticky="w")

            ctk.CTkLabel(text_frame, text="Developer: ", font=("Arial", 14)).grid(row=5, column=0, sticky="w")
            ctk.CTkLabel(text_frame, text=property["Developer"], font=("Arial", 12), text_color="gray").grid(row=5, column=1, sticky="w")

            ctk.CTkLabel(text_frame, text="Bank yang Bekerjasama: ", font=("Arial", 14)).grid(row=6, column=0, sticky="w")
            ctk.CTkLabel(text_frame, text=property["Bank yang Bekerjasama"], font=("Arial", 12), text_color="gray").grid(row=6, column=1, sticky="w")

            delete_button = ctk.CTkButton(property_frame, text="Hapus", command=lambda frame=property_frame: self.delete_property(frame))
            delete_button.grid(row=0, column=0)  # Tempatkan tombol hapus di kolom ke-3


        
        # Back button to return to the dashboard
         # Back button to return to the dashboard
        ctk.CTkButton(self, text="Kembali ke Dashboard", command=lambda: controller.show_frame("DeveloperDashboardFrame")).pack(pady=10)


    def delete_property(self, property_frame):
        property_frame.destroy()  # Menghapus frame properti dari tampilan
# Fungsi untuk menghapus properti
    def delete_selected_properties(self):
        for delete_button, property_frame in self.checkboxes:
            if delete_button.get() == 1:  # If checkbox is checked
                property_frame.destroy()  # Remove the property frame from display

# Membuat scrollable frame
            scrollable_frame = ctk.CTkScrollableFrame(master=app)
            scrollable_frame.pack(expand=True, fill='both', padx=20, pady=20)
























class AddPropertyFrame(ctk.CTkFrame):
    def __init__(self, parent, controller):
        super().__init__(parent)
        self.controller = controller


        ctk.CTkLabel(self, text="Tambah Properti Baru", font=("Arial", 24)).pack(pady=20)

        # Entry fields for new property details
        self.scrollable_frame = ctk.CTkScrollableFrame(self)
        self.scrollable_frame.pack(expand=True, fill="both", padx=20, pady=20)

       

        # Entry fields for new property details
        self.property_name_entry = ctk.CTkEntry(self.scrollable_frame, placeholder_text="Nama Properti")
        self.property_name_entry.pack(pady=10)

        self.property_price_entry = ctk.CTkEntry(self.scrollable_frame, placeholder_text="Harga")
        self.property_price_entry.pack(pady=10)

        self.property_location_entry = ctk.CTkEntry(self.scrollable_frame, placeholder_text="Lokasi")
        self.property_location_entry.pack(pady=10)

        self.property_address_entry = ctk.CTkEntry(self.scrollable_frame, placeholder_text="Alamat Lengkap")
        self.property_address_entry.pack(pady=10)


# Property type selection using radio buttons
        self.property_type_var = ctk.StringVar(value="Rumah Tinggal")  # Default value

        property_type_frame = ctk.CTkFrame(self.scrollable_frame)
        property_type_frame.pack(pady=10)

        ctk.CTkLabel(property_type_frame, text="Tipe Properti:").pack(anchor='w')

        # Radio buttons for property types
        property_types = ["Rumah Tinggal", "Ruko", "Apartemen"]
        
        for property_type in property_types:
            radio_button = ctk.CTkRadioButton(property_type_frame,
                                               text=property_type,
                                               variable=self.property_type_var,
                                               value=property_type)
            radio_button.pack(anchor='w')  # Align left


        
        # Entry for description
        self.property_description_entry = ctk.CTkEntry(self.scrollable_frame, placeholder_text="Deskripsi")
        self.property_description_entry.pack(pady=10)

        # Entry for house details
        self.phpouse_details_entry = ctk.CTkEntry(self.scrollable_frame, placeholder_text="Detail Isi Rumah")
        self.phpouse_details_entry.pack(pady=10)

        # Entry for developer
        self.developer_entry = ctk.CTkEntry(self.scrollable_frame, placeholder_text="Developer")
        self.developer_entry.pack(pady=10)

        # Entry for cooperating bank
        self.bank_entry = ctk.CTkEntry(self.scrollable_frame, placeholder_text="Bank yang Bekerjasama")
        self.bank_entry.pack(pady=10)

        # KPR option
        self.kpr_var = ctk.StringVar(value="Tidak")  # Default value
        kpr_frame = ctk.CTkFrame(self.scrollable_frame)
        kpr_frame.pack(pady=(10, 0))

        ctk.CTkLabel(kpr_frame, text="Mendukung KPR?").pack()
        
        kpr_yes_radio = ctk.CTkRadioButton(kpr_frame, text="Ya", variable=self.kpr_var, value="Ya")
        kpr_yes_radio.pack(side='left', padx=(10, 5))  # Align left with padding
        
        kpr_no_radio = ctk.CTkRadioButton(kpr_frame, text="Tidak", variable=self.kpr_var, value="Tidak")
        kpr_no_radio.pack(side='left', padx=(5, 10))  # Align left with padding

        # Cash option
        self.cash_var = ctk.StringVar(value="Tidak")  # Default value
        cash_frame = ctk.CTkFrame(self.scrollable_frame)
        cash_frame.pack(pady=(10, 0))

        ctk.CTkLabel(cash_frame, text="Apakah bisa Cash?").pack()
        
        cash_yes_radio = ctk.CTkRadioButton(cash_frame, text="Ya", variable=self.cash_var, value="Ya")
        cash_yes_radio.pack(side='left', padx=(10, 5))  # Align left with padding
        
        cash_no_radio = ctk.CTkRadioButton(cash_frame, text="Tidak", variable=self.cash_var, value="Tidak")
        cash_no_radio.pack(side='left', padx=(5, 10))  # Align left with padding

        # Button to upload an image
        self.upload_image_button = ctk.CTkButton(self.scrollable_frame, text="Unggah Gambar Detil Rumah", command=self.upload_image)
        self.upload_image_button.pack(pady=10)

        self.image_path_label = ctk.CTkLabel(self.scrollable_frame, text="Belum Ada Gambar Yang Dipilih", font=("Arial", 10))
        self.image_path_label.pack(pady=5)

        ctk.CTkButton(self, text="Ajukan Properti", command=self.add_property).pack(pady=20)

        # Variable to store the image path
        self.image_path = r"C:\Users\arche\0(python VISUAL STUDIO CODE)\Property"

    def upload_image(self):
        """Open a file dialog to select an image and update the label."""
        self.image_path = filedialog.askopenfilename(title="Select an Image",
                                                      filetypes=[("Image Files", "*.jpg;*.jpeg;*.png")])
        if self.image_path:
            self.image_path_label.configure(text=self.image_path.split("/")[-1])  # Display only the file name

    def add_property(self):
        """Logic to add the property would go here."""
        property_name = self.property_name_entry.get()
        property_price = self.property_price_entry.get()
        property_location = self.property_location_entry.get()

        print(f"Added Property: {property_name}, Price: {property_price}, Location: {property_location}, Image Path: {self.image_path}")

        # Clear entry fields after adding.
        self.property_name_entry.delete(0, 'end')
        self.property_price_entry.delete(0, 'end')
        self.property_location_entry.delete(0, 'end')
        
        # Optionally navigate back to the dashboard or show a success message.
        self.controller.show_frame("DeveloperDashboardFrame")









































class PropertyListFrame(ctk.CTkFrame):
    def __init__(self, parent, controller):
        super().__init__(parent)
        self.controller = controller

        
        ctk.CTkLabel(self, text="Properti yang anda sudah daftarkan", font=("Arial", 24)).pack(pady=20)

        scrollable_frame = ctk.CTkScrollableFrame(self)
        scrollable_frame.pack(expand=True, fill="both", padx=20, pady=20)

        # Dummy property list with details
        properties = [
            {
                "Nama": "CitraLand City CPI Makassar - Golden Avenue",
                "Harga": "Mulai Rp 5.000.000.000",
                "Lokasi": "Mariso, Makassar",
                "Deskripsi": "Rumah 2 lantai dengan desain modern, luas bangunan 166 m², dan luas tanah 162 m²",
                "Detail Rumah": "3+1 kamar tidur, 4 kamar mandi, garasi untuk 1 mobil, daya listrik 3300 Watt, sumber air PAM, dan fitur smart home.",
                "Developer": "Ciputra",
                "Bank yang Bekerjasama": "BCA",
                "Image Path": r"C:\\Users\\arche\\0(python VISUAL STUDIO CODE)\\Property\\1.jpg"
            },





            {
                "Nama": "Summarecon Mutiara Makassar - Cluster Akasia",
                "Harga": "Mulai Rp 1.100.000.000 hingga Rp 2.100.000.000",
                "Lokasi": "Summarecon Mutiara Makassar, Biring Kanaya, Makassar",
                "Deskripsi": "Perumahan dengan konsep Aeroport City, dikembangkan di atas lahan seluas 400 hektar, dekat dengan bandara dan pelabuhan baru, serta memiliki akses tol langsung.",
                "Detail Rumah": "Beragam tipe rumah dengan fasilitas kolam renang, area bermain, ruang komunitas, lapangan basket, taman hijau, keamanan 24 jam, dan sekolah.",
                "Developer": "Summarecon",
                "Bank yang Bekerjasama": "BCA",
                "Image Path": r"C:\\Users\\arche\\0(python VISUAL STUDIO CODE)\\Property\\2.jpg"
            
            },
            {
                "Nama": "Summarecon Mutiara Makassar - Jade Residence",
                "Harga": "Mulai Rp 1.100.000.000",
                "Lokasi": "Summarecon Mutiara Makassar, Biring Kanaya, Makassar",
                "Deskripsi": "Hunian mewah dengan sentuhan gaya klasik yang mewakili kemapanan dan keanggunan dengan detail arsitektur yang kaya.",
                "Detail Rumah": "Beragam tipe rumah dengan fasilitas kolam renang, area bermain, ruang komunitas, lapangan basket, taman hijau, keamanan 24 jam, dan sekolah.",
                "Developer": "Summarecon",
                "Bank yang Bekerjasama": "BCA",
                "Image Path": r"C:\\Users\\arche\\0(python VISUAL STUDIO CODE)\\Property\\3.jpg"
            },
            {
                "Nama": "Summarecon Mutiara Makassar - Jade 2 Residence",
                "Harga": "Mulai Rp 2,2 miliar (termasuk PPN dan BPHTB)",
                "Lokasi": "Summarecon Mutiara Makassar,Biring Kanaya, Makassar",
                "Deskripsi": "Properti dengan desain modern klasik, menawarkan kenyamanan dan kemewahan bagi penghuninya.",
                "Detail Rumah": "-",
                "Developer": "Summarecon",
                "Bank yang Bekerjasama": "BCA",
                "Image Path": r"C:\Users\arche\0(python VISUAL STUDIO CODE)\Property\4.jpg"
            },
            {
                "Nama": "Summarecon Mutiara Makassar - The Topaz Residence",
                "Harga": "Mulai Rp 2,1 miliar (termasuk PPN dan BPHTB)",
                "Lokasi": "Summarecon Mutiara Makassar,Biring Kanaya, Makassar",
                "Deskripsi": "Cluster dengan desain modern, menawarkan kenyamanan bagi penghuninya.",
                "Detail Rumah": "-",
                "Developer": "Summarecon",
                "Bank yang Bekerjasama": "BCA",
                "Image Path": r"C:\Users\arche\0(python VISUAL STUDIO CODE)\Property\5.jpg"
            },
            {
                "Nama": "Summarecon Mutiara Makassar - The Topaz Residence Type Sherry",
                "Harga": "Mulai Rp 2,5 miliar (termasuk PPN dan BPHTB)",
                "Lokasi": "Summarecon Mutiara Makassar,Biring Kanaya, Makassar",
                "Deskripsi": "Hunian dengan desain modern yang memukau, menggabungkan elegansi dan kenyamanan.",
                "Detail Rumah": "-",
                "Developer": "Summarecon",
                "Bank yang Bekerjasama": "BCA",
                "Image Path": r"C:\Users\arche\0(python VISUAL STUDIO CODE)\Property\6.jpg"
            },
            {
                "Nama": "Summarecon Mutiara Makassar - Beryl Residence",
                "Harga": "Mulai Rp 1,2 miliar (termasuk PPN dan BPHTB)",
                "Lokasi": "Summarecon Mutiara Makassar,Biring Kanaya, Makassar",
                "Deskripsi": "Cluster dengan fasilitas umum seperti kolam renang, clubhouse, dan area bermain anak.",
                "Detail Rumah": "-",
                "Developer": "Summarecon",
                "Bank yang Bekerjasama": "BCA",
                "Image Path": r"C:\Users\arche\0(python VISUAL STUDIO CODE)\Property\7.jpg"
            },
            {
                "Nama": "Summarecon Mutiara Makassar - Blue Crystal",
                "Harga": "Mulai Rp 2 miliar (termasuk PPN dan BPHTB)",
                "Lokasi": "Summarecon Mutiara Makassar,Biring Kanaya, Makassar",
                "Deskripsi": "Cluster dengan desain tropis kontemporer, dilengkapi fasilitas umum yang mendukung kenyamanan penghuni.",
                "Detail Rumah": "-",
                "Developer": "Summarecon",
                "Bank yang Bekerjasama": "BCA",
                "Image Path": r"C:\Users\arche\0(python VISUAL STUDIO CODE)\Property\8.jpg"
            },
            {
                "Nama": "Summarecon Mutiara Makassar - Green Crystal",
                "Harga": "Mulai Rp 2 miliar (termasuk PPN dan BPHTB)",
                "Lokasi": "Summarecon Mutiara Makassar,Biring Kanaya, Makassar",
                "Deskripsi": "Cluster dengan fasilitas modern, menawarkan kenyamanan dan kemewahan bagi penghuninya.",
                "Detail Rumah": "-",
                "Developer": "Summarecon",
                "Bank yang Bekerjasama": "BCA",
                "Image Path": r"C:\Users\arche\0(python VISUAL STUDIO CODE)\Property\9.jpg"
            },
            {
                "Nama": "Summarecon Mutiara Makassar - The Morizen Makassar",
                "Harga": "Mulai Rp 10 miliar (termasuk PPN dan BPHTB)",
                "Lokasi": "Summarecon Mutiara Makassar,Biring Kanaya, Makassar",
                "Deskripsi": "Hunian dengan konsep Jepang, menawarkan keseimbangan antara elegansi dan kenyamanan.",
                "Detail Rumah": "-",
                "Developer": "Summarecon",
                "Bank yang Bekerjasama": "BCA",
                "Image Path": r"C:\Users\arche\0(python VISUAL STUDIO CODE)\Property\10.jpg"
            },
            {
                "Nama": "Summarecon Mutiara Makassar - Ruko Graha Boulevard Makassar",
                "Harga": "Mulai Rp 1,5 miliar (termasuk PPN dan BPHTB)",
                "Lokasi": "Summarecon Mutiara Makassar,Biring Kanaya, Makassar",
                "Deskripsi": "Ruko 3 lantai dengan lokasi strategis, cocok untuk berbagai jenis usaha. ",
                "Detail Rumah": "Luas bangunan 115 m², 1 kamar mandi",
                "Developer": "Summarecon",
                "Bank yang Bekerjasama": "BCA",
                "Image Path": r"C:\Users\arche\0(python VISUAL STUDIO CODE)\Property\11.jpg"
            },






            {
                "Nama": "Virginia Park Makassar",
                "Harga": "Mulai Rp 1.000.000.000 hingga Rp 2.000.000.000",
                "Lokasi": "Biring Kanaya, Makassar",
                "Deskripsi": "Perumahan mewah dengan konsep Luxury Home with Green Development Concept, menawarkan hunian mewah dengan lingkungan hijau yang nyaman.",
                "Detail Rumah": "-",
                "Developer": "Brighton Real Estate",
                "Bank yang Bekerjasama": "-",
                "Image Path": r"C:\Users\arche\0(python VISUAL STUDIO CODE)\Property\12.jpg"
            },
             {
                "Nama": "Perumahan Grand Barombong",
                "Harga": "Rp 177.000.000",
                "Lokasi": "Makassar",
                "Deskripsi": "Rumah tinggal 1 lantai dengan lokasi strategis dan harga terjangkau.",
                "Detail Rumah": "Luas tanah 72 m², luas bangunan 36 m².",
                "Developer": "-",
                "Bank yang Bekerjasama": "-",
                "Image Path": r"C:\Users\arche\0(python VISUAL STUDIO CODE)\Property\13.jpg"
            },
             {
                "Nama": "Royal Sentraland BTP Makassar",
                "Harga": "Rp 330.000.000",
                "Lokasi": "Makassar",
                "Deskripsi": "Rumah tinggal 2 lantai dengan 3 kamar tidur dan 3 kamar mandi.",
                "Detail Rumah": "Luas tanah 84 m², luas bangunan 84 m².",
                "Developer": "-",
                "Bank yang Bekerjasama": "-",
                "Image Path": r"C:\Users\arche\0(python VISUAL STUDIO CODE)\Property\14.jpg"
            },
            {
                "Nama": "Rumah Tengah Kota Makassar",
                "Harga": "Mulai Rp 588.000.000",
                "Lokasi": "Makassar",
                "Deskripsi": "Rumah tersedia dalam 2 tipe, 1 dan 2 lantai, dengan opsi cicilan developer maksimal 3 tahun tanpa bank dan tanpa bunga.",
                "Detail Rumah": "-",
                "Developer": "Rajata",
                "Bank yang Bekerjasama": "-",
                "Image Path": r"C:\Users\arche\0(python VISUAL STUDIO CODE)\Property\15.jpg"
            },
             {
                "Nama": "Perumahan Green Residence Sudiang",
                "Harga": "Mulai Rp 700.000.000",
                "Lokasi": "Sudiang, Makassar",
                "Deskripsi": " Kawasan ramah lingkungan dengan fasilitas taman hijau dan sistem cluster.",
                "Detail Rumah": "Rumah 1 lantai, 2 kamar tidur, 1 kamar mandi, luas tanah 72 m².",
                "Developer": "GreenLand Developer",
                "Bank yang Bekerjasama": "Bank Mandiri, BNI",
                "Image Path": r"C:\Users\arche\0(python VISUAL STUDIO CODE)\Property\16.jpg"
            },
            {
                "Nama": "Perumahan Taman Sari Makassar",
                "Harga": "Mulai Rp 1.200.000.000",
                "Lokasi": "Tamalanrea, Makassar",
                "Deskripsi": "Perumahan dengan konsep modern minimalis, dilengkapi dengan fasilitas keamanan 24 jam dan taman bermain anak.",
                "Detail Rumah": "Rumah 2 lantai, 3 kamar tidur, 2 kamar mandi, luas tanah 90 m².",
                "Developer": "PT. Taman Sari Makassar",
                "Bank yang Bekerjasama": "BCA, BRI",
                "Image Path": r"C:\Users\arche\0(python VISUAL STUDIO CODE)\Property\17.jpg"
            },
             {
                "Nama": "Perumahan Bukit Baruga Antang",
                "Harga": "Mulai Rp 900.000.000",
                "Lokasi": "Antang, Makassar",
                "Deskripsi": "Perumahan dengan lingkungan asri,",
                "Detail Rumah": "-",
                "Developer": "Bukit Baruga",
                "Bank yang Bekerjasama": "BCA",
                "Image Path": r"C:\Users\arche\0(python VISUAL STUDIO CODE)\Property\18.jpg"
            },
             
            
        ]

        for property in properties:
            # Create a frame for each property
            property_frame = ctk.CTkFrame(scrollable_frame)
            property_frame.pack(fill='x', padx=5, pady=5)
            img_path = property.get("Image Path")
            # Load and display the property image
            img_path = property["Image Path"]
            if img_path:  # Check if img_path is not None
                img = Image.open(img_path)
                img = img.resize((400, 400), Image.LANCZOS)  # Resize as needed
                img_photo = ImageTk.PhotoImage(img)

        # Create labels for the image and text
                image_label = ctk.CTkLabel(property_frame, image=img_photo)
                image_label.image = img_photo  # Keep a reference to avoid garbage collection
                image_label.grid(row=0, column=0, padx=10)

            # Create a frame for text information
            text_frame = ctk.CTkFrame(property_frame)
            text_frame.grid(row=0, column=1, padx=10)

            # Add property details to the text frame
            ctk.CTkLabel(text_frame, text="Nama: ", font=("Arial", 14)).grid(row=0, column=0, sticky="w")
            ctk.CTkLabel(text_frame, text=property["Nama"], font=("Arial", 14)).grid(row=0, column=1, sticky="w")

            ctk.CTkLabel(text_frame, text="Harga: ", font=("Arial", 14)).grid(row=1, column=0, sticky="w")
            ctk.CTkLabel(text_frame, text=property["Harga"], font=("Arial", 14)).grid(row=1, column=1, sticky="w")

            ctk.CTkLabel(text_frame, text="Lokasi: ", font=("Arial", 14)).grid(row=2, column=0, sticky="w")
            ctk.CTkLabel(text_frame, text=property["Lokasi"], font=("Arial", 14)).grid(row=2, column=1, sticky="w")

            ctk.CTkLabel(text_frame, text="Deskripsi: ", font=("Arial", 14)).grid(row=3, column=0, sticky="w")
            ctk.CTkLabel(text_frame, text=property["Deskripsi"], font=("Arial", 12), text_color="gray").grid(row=3, column=1, sticky="w")

            ctk.CTkLabel(text_frame, text="Detail Rumah: ", font=("Arial", 14)).grid(row=4, column=0, sticky="w")
            ctk.CTkLabel(text_frame, text=property["Detail Rumah"], font=("Arial", 12), text_color="gray").grid(row=4, column=1, sticky="w")

            ctk.CTkLabel(text_frame, text="Developer: ", font=("Arial", 14)).grid(row=5, column=0, sticky="w")
            ctk.CTkLabel(text_frame, text=property["Developer"], font=("Arial", 12), text_color="gray").grid(row=5, column=1, sticky="w")

            ctk.CTkLabel(text_frame, text="Bank yang Bekerjasama: ", font=("Arial", 14)).grid(row=6, column=0, sticky="w")
            ctk.CTkLabel(text_frame, text=property["Bank yang Bekerjasama"], font=("Arial", 12), text_color="gray").grid(row=6, column=1, sticky="w")
        # Back button to return to the dashboard
         # Back button to return to the dashboard
        ctk.CTkButton(self, text="Kembali ke Dashboard", command=lambda: controller.show_frame("DeveloperDashboardFrame")).pack(pady=10)


















































class BEditPropertyFrame(ctk.CTkFrame):
    def __init__(self, parent, controller):
        super().__init__(parent)
        self.controller = controller

    
        ctk.CTkLabel(self, text="Silahkan Tekan 'Laporkan' Jika Anda Menemukan Adanya Properti Yang Sudah Sold Out atau Bermasalah", font=("Arial", 24)).pack(pady=20)

        scrollable_frame = ctk.CTkScrollableFrame(self)
        scrollable_frame.pack(expand=True, fill="both", padx=20, pady=20)

        # Dummy property list with details
        properties = [
            {
                "Nama": "CitraLand City CPI Makassar - Golden Avenue",
                "Harga": "Mulai Rp 5.000.000.000",
                "Lokasi": "Mariso, Makassar",
                "Deskripsi": "Rumah 2 lantai dengan desain modern, luas bangunan 166 m², dan luas tanah 162 m²",
                "Detail Rumah": "3+1 kamar tidur, 4 kamar mandi, garasi untuk 1 mobil, daya listrik 3300 Watt, sumber air PAM, dan fitur smart home.",
                "Developer": "Ciputra",
                "Bank yang Bekerjasama": "BCA",
                "Image Path": r"C:\\Users\\arche\\0(python VISUAL STUDIO CODE)\\Property\\1.jpg"
            },





            {
                "Nama": "Summarecon Mutiara Makassar - Cluster Akasia",
                "Harga": "Mulai Rp 1.100.000.000 hingga Rp 2.100.000.000",
                "Lokasi": "Summarecon Mutiara Makassar, Biring Kanaya, Makassar",
                "Deskripsi": "Perumahan dengan konsep Aeroport City, dikembangkan di atas lahan seluas 400 hektar, dekat dengan bandara dan pelabuhan baru, serta memiliki akses tol langsung.",
                "Detail Rumah": "Beragam tipe rumah dengan fasilitas kolam renang, area bermain, ruang komunitas, lapangan basket, taman hijau, keamanan 24 jam, dan sekolah.",
                "Developer": "Summarecon",
                "Bank yang Bekerjasama": "BCA",
                "Image Path": r"C:\\Users\\arche\\0(python VISUAL STUDIO CODE)\\Property\\2.jpg"
            
            },
            {
                "Nama": "Summarecon Mutiara Makassar - Jade Residence",
                "Harga": "Mulai Rp 1.100.000.000",
                "Lokasi": "Summarecon Mutiara Makassar, Biring Kanaya, Makassar",
                "Deskripsi": "Hunian mewah dengan sentuhan gaya klasik yang mewakili kemapanan dan keanggunan dengan detail arsitektur yang kaya.",
                "Detail Rumah": "Beragam tipe rumah dengan fasilitas kolam renang, area bermain, ruang komunitas, lapangan basket, taman hijau, keamanan 24 jam, dan sekolah.",
                "Developer": "Summarecon",
                "Bank yang Bekerjasama": "BCA",
                "Image Path": r"C:\\Users\\arche\\0(python VISUAL STUDIO CODE)\\Property\\3.jpg"
            },
            {
                "Nama": "Summarecon Mutiara Makassar - Jade 2 Residence",
                "Harga": "Mulai Rp 2,2 miliar (termasuk PPN dan BPHTB)",
                "Lokasi": "Summarecon Mutiara Makassar,Biring Kanaya, Makassar",
                "Deskripsi": "Properti dengan desain modern klasik, menawarkan kenyamanan dan kemewahan bagi penghuninya.",
                "Detail Rumah": "-",
                "Developer": "Summarecon",
                "Bank yang Bekerjasama": "BCA",
                "Image Path": r"C:\Users\arche\0(python VISUAL STUDIO CODE)\Property\4.jpg"
            },
            {
                "Nama": "Summarecon Mutiara Makassar - The Topaz Residence",
                "Harga": "Mulai Rp 2,1 miliar (termasuk PPN dan BPHTB)",
                "Lokasi": "Summarecon Mutiara Makassar,Biring Kanaya, Makassar",
                "Deskripsi": "Cluster dengan desain modern, menawarkan kenyamanan bagi penghuninya.",
                "Detail Rumah": "-",
                "Developer": "Summarecon",
                "Bank yang Bekerjasama": "BCA",
                "Image Path": r"C:\Users\arche\0(python VISUAL STUDIO CODE)\Property\5.jpg"
            },
            {
                "Nama": "Summarecon Mutiara Makassar - The Topaz Residence Type Sherry",
                "Harga": "Mulai Rp 2,5 miliar (termasuk PPN dan BPHTB)",
                "Lokasi": "Summarecon Mutiara Makassar,Biring Kanaya, Makassar",
                "Deskripsi": "Hunian dengan desain modern yang memukau, menggabungkan elegansi dan kenyamanan.",
                "Detail Rumah": "-",
                "Developer": "Summarecon",
                "Bank yang Bekerjasama": "BCA",
                "Image Path": r"C:\Users\arche\0(python VISUAL STUDIO CODE)\Property\6.jpg"
            },
            {
                "Nama": "Summarecon Mutiara Makassar - Beryl Residence",
                "Harga": "Mulai Rp 1,2 miliar (termasuk PPN dan BPHTB)",
                "Lokasi": "Summarecon Mutiara Makassar,Biring Kanaya, Makassar",
                "Deskripsi": "Cluster dengan fasilitas umum seperti kolam renang, clubhouse, dan area bermain anak.",
                "Detail Rumah": "-",
                "Developer": "Summarecon",
                "Bank yang Bekerjasama": "BCA",
                "Image Path": r"C:\Users\arche\0(python VISUAL STUDIO CODE)\Property\7.jpg"
            },
            {
                "Nama": "Summarecon Mutiara Makassar - Blue Crystal",
                "Harga": "Mulai Rp 2 miliar (termasuk PPN dan BPHTB)",
                "Lokasi": "Summarecon Mutiara Makassar,Biring Kanaya, Makassar",
                "Deskripsi": "Cluster dengan desain tropis kontemporer, dilengkapi fasilitas umum yang mendukung kenyamanan penghuni.",
                "Detail Rumah": "-",
                "Developer": "Summarecon",
                "Bank yang Bekerjasama": "BCA",
                "Image Path": r"C:\Users\arche\0(python VISUAL STUDIO CODE)\Property\8.jpg"
            },
            {
                "Nama": "Summarecon Mutiara Makassar - Green Crystal",
                "Harga": "Mulai Rp 2 miliar (termasuk PPN dan BPHTB)",
                "Lokasi": "Summarecon Mutiara Makassar,Biring Kanaya, Makassar",
                "Deskripsi": "Cluster dengan fasilitas modern, menawarkan kenyamanan dan kemewahan bagi penghuninya.",
                "Detail Rumah": "-",
                "Developer": "Summarecon",
                "Bank yang Bekerjasama": "BCA",
                "Image Path": r"C:\Users\arche\0(python VISUAL STUDIO CODE)\Property\9.jpg"
            },
            {
                "Nama": "Summarecon Mutiara Makassar - The Morizen Makassar",
                "Harga": "Mulai Rp 10 miliar (termasuk PPN dan BPHTB)",
                "Lokasi": "Summarecon Mutiara Makassar,Biring Kanaya, Makassar",
                "Deskripsi": "Hunian dengan konsep Jepang, menawarkan keseimbangan antara elegansi dan kenyamanan.",
                "Detail Rumah": "-",
                "Developer": "Summarecon",
                "Bank yang Bekerjasama": "BCA",
                "Image Path": r"C:\Users\arche\0(python VISUAL STUDIO CODE)\Property\10.jpg"
            },
            {
                "Nama": "Summarecon Mutiara Makassar - Ruko Graha Boulevard Makassar",
                "Harga": "Mulai Rp 1,5 miliar (termasuk PPN dan BPHTB)",
                "Lokasi": "Summarecon Mutiara Makassar,Biring Kanaya, Makassar",
                "Deskripsi": "Ruko 3 lantai dengan lokasi strategis, cocok untuk berbagai jenis usaha. ",
                "Detail Rumah": "Luas bangunan 115 m², 1 kamar mandi",
                "Developer": "Summarecon",
                "Bank yang Bekerjasama": "BCA",
                "Image Path": r"C:\Users\arche\0(python VISUAL STUDIO CODE)\Property\11.jpg"
            },






            {
                "Nama": "Virginia Park Makassar",
                "Harga": "Mulai Rp 1.000.000.000 hingga Rp 2.000.000.000",
                "Lokasi": "Biring Kanaya, Makassar",
                "Deskripsi": "Perumahan mewah dengan konsep Luxury Home with Green Development Concept, menawarkan hunian mewah dengan lingkungan hijau yang nyaman.",
                "Detail Rumah": "-",
                "Developer": "Brighton Real Estate",
                "Bank yang Bekerjasama": "-",
                "Image Path": r"C:\Users\arche\0(python VISUAL STUDIO CODE)\Property\12.jpg"
            },
             {
                "Nama": "Perumahan Grand Barombong",
                "Harga": "Rp 177.000.000",
                "Lokasi": "Makassar",
                "Deskripsi": "Rumah tinggal 1 lantai dengan lokasi strategis dan harga terjangkau.",
                "Detail Rumah": "Luas tanah 72 m², luas bangunan 36 m².",
                "Developer": "-",
                "Bank yang Bekerjasama": "-",
                "Image Path": r"C:\Users\arche\0(python VISUAL STUDIO CODE)\Property\13.jpg"
            },
             {
                "Nama": "Royal Sentraland BTP Makassar",
                "Harga": "Rp 330.000.000",
                "Lokasi": "Makassar",
                "Deskripsi": "Rumah tinggal 2 lantai dengan 3 kamar tidur dan 3 kamar mandi.",
                "Detail Rumah": "Luas tanah 84 m², luas bangunan 84 m².",
                "Developer": "-",
                "Bank yang Bekerjasama": "-",
                "Image Path": r"C:\Users\arche\0(python VISUAL STUDIO CODE)\Property\14.jpg"
            },
            {
                "Nama": "Rumah Tengah Kota Makassar",
                "Harga": "Mulai Rp 588.000.000",
                "Lokasi": "Makassar",
                "Deskripsi": "Rumah tersedia dalam 2 tipe, 1 dan 2 lantai, dengan opsi cicilan developer maksimal 3 tahun tanpa bank dan tanpa bunga.",
                "Detail Rumah": "-",
                "Developer": "Rajata",
                "Bank yang Bekerjasama": "-",
                "Image Path": r"C:\Users\arche\0(python VISUAL STUDIO CODE)\Property\15.jpg"
            },
             {
                "Nama": "Perumahan Green Residence Sudiang",
                "Harga": "Mulai Rp 700.000.000",
                "Lokasi": "Sudiang, Makassar",
                "Deskripsi": " Kawasan ramah lingkungan dengan fasilitas taman hijau dan sistem cluster.",
                "Detail Rumah": "Rumah 1 lantai, 2 kamar tidur, 1 kamar mandi, luas tanah 72 m².",
                "Developer": "GreenLand Developer",
                "Bank yang Bekerjasama": "Bank Mandiri, BNI",
                "Image Path": r"C:\Users\arche\0(python VISUAL STUDIO CODE)\Property\16.jpg"
            },
            {
                "Nama": "Perumahan Taman Sari Makassar",
                "Harga": "Mulai Rp 1.200.000.000",
                "Lokasi": "Tamalanrea, Makassar",
                "Deskripsi": "Perumahan dengan konsep modern minimalis, dilengkapi dengan fasilitas keamanan 24 jam dan taman bermain anak.",
                "Detail Rumah": "Rumah 2 lantai, 3 kamar tidur, 2 kamar mandi, luas tanah 90 m².",
                "Developer": "PT. Taman Sari Makassar",
                "Bank yang Bekerjasama": "BCA, BRI",
                "Image Path": r"C:\Users\arche\0(python VISUAL STUDIO CODE)\Property\17.jpg"
            },
            
             {
                "Nama": "Perumahan Bukit Baruga Antang",
                "Harga": "Mulai Rp 900.000.000",
                "Lokasi": "Antang, Makassar",
                "Deskripsi": "Perumahan dengan lingkungan asri,",
                "Detail Rumah": "-",
                "Developer": "Bukit Baruga",
                "Bank yang Bekerjasama": "BCA",
                "Image Path": r"C:\Users\arche\0(python VISUAL STUDIO CODE)\Property\18.jpg"
            },
             
            
        ]
        self.checkboxes = []  # List to hold checkbox variables

        for property in properties:
            # Create a frame for each property
            property_frame = ctk.CTkFrame(scrollable_frame)
            property_frame.pack(fill='x', padx=5, pady=5)



            checkbox_var = ctk.IntVar()  # Variabel untuk menyimpan status checkbox
            checkbox = ctk.CTkCheckBox(property_frame, variable=checkbox_var)
            checkbox.grid(row=0, column=0, padx=10)
            self.checkboxes.append((checkbox_var, property_frame))  # Simpan variabel dan frame

            img_path = property.get("Image Path")
            # Load and display the property image
            img_path = property["Image Path"]
            if img_path:  # Check if img_path is not None
                img = Image.open(img_path)
                img = img.resize((400, 400), Image.LANCZOS)  # Resize as needed
                img_photo = ImageTk.PhotoImage(img)

        # Create labels for the image and text
                image_label = ctk.CTkLabel(property_frame, image=img_photo)
                image_label.image = img_photo  # Keep a reference to avoid garbage collection
                image_label.grid(row=0, column=1, padx=10)

            # Create a frame for text information
            text_frame = ctk.CTkFrame(property_frame)
            text_frame.grid(row=0, column=2, padx=10)

            # Add property details to the text frame
            ctk.CTkLabel(text_frame, text="Nama: ", font=("Arial", 14)).grid(row=0, column=0, sticky="w")
            ctk.CTkLabel(text_frame, text=property["Nama"], font=("Arial", 14)).grid(row=0, column=1, sticky="w")

            ctk.CTkLabel(text_frame, text="Harga: ", font=("Arial", 14)).grid(row=1, column=0, sticky="w")
            ctk.CTkLabel(text_frame, text=property["Harga"], font=("Arial", 14)).grid(row=1, column=1, sticky="w")

            ctk.CTkLabel(text_frame, text="Lokasi: ", font=("Arial", 14)).grid(row=2, column=0, sticky="w")
            ctk.CTkLabel(text_frame, text=property["Lokasi"], font=("Arial", 14)).grid(row=2, column=1, sticky="w")

            ctk.CTkLabel(text_frame, text="Deskripsi: ", font=("Arial", 14)).grid(row=3, column=0, sticky="w")
            ctk.CTkLabel(text_frame, text=property["Deskripsi"], font=("Arial", 12), text_color="gray").grid(row=3, column=1, sticky="w")

            ctk.CTkLabel(text_frame, text="Detail Rumah: ", font=("Arial", 14)).grid(row=4, column=0, sticky="w")
            ctk.CTkLabel(text_frame, text=property["Detail Rumah"], font=("Arial", 12), text_color="gray").grid(row=4, column=1, sticky="w")

            ctk.CTkLabel(text_frame, text="Developer: ", font=("Arial", 14)).grid(row=5, column=0, sticky="w")
            ctk.CTkLabel(text_frame, text=property["Developer"], font=("Arial", 12), text_color="gray").grid(row=5, column=1, sticky="w")

            ctk.CTkLabel(text_frame, text="Bank yang Bekerjasama: ", font=("Arial", 14)).grid(row=6, column=0, sticky="w")
            ctk.CTkLabel(text_frame, text=property["Bank yang Bekerjasama"], font=("Arial", 12), text_color="gray").grid(row=6, column=1, sticky="w")

            delete_button = ctk.CTkButton(property_frame, text="Laporkan", command=lambda frame=property_frame: self.delete_property(frame))
            delete_button.grid(row=0, column=0)  # Tempatkan tombol hapus di kolom ke-3


        
        # Back button to return to the dashboard
         # Back button to return to the dashboard
        ctk.CTkButton(self, text="Kembali ke Dashboard", command=lambda: controller.show_frame("BuyerDashboardFrame")).pack(pady=10)


    def delete_property(self, property_frame):
        property_frame.destroy()  # Menghapus frame properti dari tampilan
# Fungsi untuk menghapus properti
    def delete_selected_properties(self):
        for delete_button, property_frame in self.checkboxes:
            if delete_button.get() == 1:  # If checkbox is checked
                property_frame.destroy()  # Remove the property frame from display

# Membuat scrollable frame
            scrollable_frame = ctk.CTkScrollableFrame(master=app)
            scrollable_frame.pack(expand=True, fill='both', padx=20, pady=20)































class SEditPropertyFrame(ctk.CTkFrame):
    def __init__(self, parent, controller):
        super().__init__(parent)
        self.controller = controller

    
        ctk.CTkLabel(self, text="Hapus Properti dari Daftar Listingan Anda", font=("Arial", 24)).pack(pady=20)

        scrollable_frame = ctk.CTkScrollableFrame(self)
        scrollable_frame.pack(expand=True, fill="both", padx=20, pady=20)

        # Dummy property list with details
        properties = [
            {
                "Nama": "CitraLand City CPI Makassar - Golden Avenue",
                "Harga": "Mulai Rp 5.000.000.000",
                "Lokasi": "Mariso, Makassar",
                "Deskripsi": "Rumah 2 lantai dengan desain modern, luas bangunan 166 m², dan luas tanah 162 m²",
                "Detail Rumah": "3+1 kamar tidur, 4 kamar mandi, garasi untuk 1 mobil, daya listrik 3300 Watt, sumber air PAM, dan fitur smart home.",
                "Developer": "Ciputra",
                "Bank yang Bekerjasama": "BCA",
                "Image Path": r"C:\\Users\\arche\\0(python VISUAL STUDIO CODE)\\Property\\1.jpg"
            },





            {
                "Nama": "Summarecon Mutiara Makassar - Cluster Akasia",
                "Harga": "Mulai Rp 1.100.000.000 hingga Rp 2.100.000.000",
                "Lokasi": "Summarecon Mutiara Makassar, Biring Kanaya, Makassar",
                "Deskripsi": "Perumahan dengan konsep Aeroport City, dikembangkan di atas lahan seluas 400 hektar, dekat dengan bandara dan pelabuhan baru, serta memiliki akses tol langsung.",
                "Detail Rumah": "Beragam tipe rumah dengan fasilitas kolam renang, area bermain, ruang komunitas, lapangan basket, taman hijau, keamanan 24 jam, dan sekolah.",
                "Developer": "Summarecon",
                "Bank yang Bekerjasama": "BCA",
                "Image Path": r"C:\\Users\\arche\\0(python VISUAL STUDIO CODE)\\Property\\2.jpg"
            
            },
            {
                "Nama": "Summarecon Mutiara Makassar - Jade Residence",
                "Harga": "Mulai Rp 1.100.000.000",
                "Lokasi": "Summarecon Mutiara Makassar, Biring Kanaya, Makassar",
                "Deskripsi": "Hunian mewah dengan sentuhan gaya klasik yang mewakili kemapanan dan keanggunan dengan detail arsitektur yang kaya.",
                "Detail Rumah": "Beragam tipe rumah dengan fasilitas kolam renang, area bermain, ruang komunitas, lapangan basket, taman hijau, keamanan 24 jam, dan sekolah.",
                "Developer": "Summarecon",
                "Bank yang Bekerjasama": "BCA",
                "Image Path": r"C:\\Users\\arche\\0(python VISUAL STUDIO CODE)\\Property\\3.jpg"
            },
            {
                "Nama": "Summarecon Mutiara Makassar - Jade 2 Residence",
                "Harga": "Mulai Rp 2,2 miliar (termasuk PPN dan BPHTB)",
                "Lokasi": "Summarecon Mutiara Makassar,Biring Kanaya, Makassar",
                "Deskripsi": "Properti dengan desain modern klasik, menawarkan kenyamanan dan kemewahan bagi penghuninya.",
                "Detail Rumah": "-",
                "Developer": "Summarecon",
                "Bank yang Bekerjasama": "BCA",
                "Image Path": r"C:\Users\arche\0(python VISUAL STUDIO CODE)\Property\4.jpg"
            },
            {
                "Nama": "Summarecon Mutiara Makassar - The Topaz Residence",
                "Harga": "Mulai Rp 2,1 miliar (termasuk PPN dan BPHTB)",
                "Lokasi": "Summarecon Mutiara Makassar,Biring Kanaya, Makassar",
                "Deskripsi": "Cluster dengan desain modern, menawarkan kenyamanan bagi penghuninya.",
                "Detail Rumah": "-",
                "Developer": "Summarecon",
                "Bank yang Bekerjasama": "BCA",
                "Image Path": r"C:\Users\arche\0(python VISUAL STUDIO CODE)\Property\5.jpg"
            },
            {
                "Nama": "Summarecon Mutiara Makassar - The Topaz Residence Type Sherry",
                "Harga": "Mulai Rp 2,5 miliar (termasuk PPN dan BPHTB)",
                "Lokasi": "Summarecon Mutiara Makassar,Biring Kanaya, Makassar",
                "Deskripsi": "Hunian dengan desain modern yang memukau, menggabungkan elegansi dan kenyamanan.",
                "Detail Rumah": "-",
                "Developer": "Summarecon",
                "Bank yang Bekerjasama": "BCA",
                "Image Path": r"C:\Users\arche\0(python VISUAL STUDIO CODE)\Property\6.jpg"
            },
            {
                "Nama": "Summarecon Mutiara Makassar - Beryl Residence",
                "Harga": "Mulai Rp 1,2 miliar (termasuk PPN dan BPHTB)",
                "Lokasi": "Summarecon Mutiara Makassar,Biring Kanaya, Makassar",
                "Deskripsi": "Cluster dengan fasilitas umum seperti kolam renang, clubhouse, dan area bermain anak.",
                "Detail Rumah": "-",
                "Developer": "Summarecon",
                "Bank yang Bekerjasama": "BCA",
                "Image Path": r"C:\Users\arche\0(python VISUAL STUDIO CODE)\Property\7.jpg"
            },
            {
                "Nama": "Summarecon Mutiara Makassar - Blue Crystal",
                "Harga": "Mulai Rp 2 miliar (termasuk PPN dan BPHTB)",
                "Lokasi": "Summarecon Mutiara Makassar,Biring Kanaya, Makassar",
                "Deskripsi": "Cluster dengan desain tropis kontemporer, dilengkapi fasilitas umum yang mendukung kenyamanan penghuni.",
                "Detail Rumah": "-",
                "Developer": "Summarecon",
                "Bank yang Bekerjasama": "BCA",
                "Image Path": r"C:\Users\arche\0(python VISUAL STUDIO CODE)\Property\8.jpg"
            },
            {
                "Nama": "Summarecon Mutiara Makassar - Green Crystal",
                "Harga": "Mulai Rp 2 miliar (termasuk PPN dan BPHTB)",
                "Lokasi": "Summarecon Mutiara Makassar,Biring Kanaya, Makassar",
                "Deskripsi": "Cluster dengan fasilitas modern, menawarkan kenyamanan dan kemewahan bagi penghuninya.",
                "Detail Rumah": "-",
                "Developer": "Summarecon",
                "Bank yang Bekerjasama": "BCA",
                "Image Path": r"C:\Users\arche\0(python VISUAL STUDIO CODE)\Property\9.jpg"
            },
            {
                "Nama": "Summarecon Mutiara Makassar - The Morizen Makassar",
                "Harga": "Mulai Rp 10 miliar (termasuk PPN dan BPHTB)",
                "Lokasi": "Summarecon Mutiara Makassar,Biring Kanaya, Makassar",
                "Deskripsi": "Hunian dengan konsep Jepang, menawarkan keseimbangan antara elegansi dan kenyamanan.",
                "Detail Rumah": "-",
                "Developer": "Summarecon",
                "Bank yang Bekerjasama": "BCA",
                "Image Path": r"C:\Users\arche\0(python VISUAL STUDIO CODE)\Property\10.jpg"
            },
            {
                "Nama": "Summarecon Mutiara Makassar - Ruko Graha Boulevard Makassar",
                "Harga": "Mulai Rp 1,5 miliar (termasuk PPN dan BPHTB)",
                "Lokasi": "Summarecon Mutiara Makassar,Biring Kanaya, Makassar",
                "Deskripsi": "Ruko 3 lantai dengan lokasi strategis, cocok untuk berbagai jenis usaha. ",
                "Detail Rumah": "Luas bangunan 115 m², 1 kamar mandi",
                "Developer": "Summarecon",
                "Bank yang Bekerjasama": "BCA",
                "Image Path": r"C:\Users\arche\0(python VISUAL STUDIO CODE)\Property\11.jpg"
            },






            {
                "Nama": "Virginia Park Makassar",
                "Harga": "Mulai Rp 1.000.000.000 hingga Rp 2.000.000.000",
                "Lokasi": "Biring Kanaya, Makassar",
                "Deskripsi": "Perumahan mewah dengan konsep Luxury Home with Green Development Concept, menawarkan hunian mewah dengan lingkungan hijau yang nyaman.",
                "Detail Rumah": "-",
                "Developer": "Brighton Real Estate",
                "Bank yang Bekerjasama": "-",
                "Image Path": r"C:\Users\arche\0(python VISUAL STUDIO CODE)\Property\12.jpg"
            },
             {
                "Nama": "Perumahan Grand Barombong",
                "Harga": "Rp 177.000.000",
                "Lokasi": "Makassar",
                "Deskripsi": "Rumah tinggal 1 lantai dengan lokasi strategis dan harga terjangkau.",
                "Detail Rumah": "Luas tanah 72 m², luas bangunan 36 m².",
                "Developer": "-",
                "Bank yang Bekerjasama": "-",
                "Image Path": r"C:\Users\arche\0(python VISUAL STUDIO CODE)\Property\13.jpg"
            },
             {
                "Nama": "Royal Sentraland BTP Makassar",
                "Harga": "Rp 330.000.000",
                "Lokasi": "Makassar",
                "Deskripsi": "Rumah tinggal 2 lantai dengan 3 kamar tidur dan 3 kamar mandi.",
                "Detail Rumah": "Luas tanah 84 m², luas bangunan 84 m².",
                "Developer": "-",
                "Bank yang Bekerjasama": "-",
                "Image Path": r"C:\Users\arche\0(python VISUAL STUDIO CODE)\Property\14.jpg"
            },
            {
                "Nama": "Rumah Tengah Kota Makassar",
                "Harga": "Mulai Rp 588.000.000",
                "Lokasi": "Makassar",
                "Deskripsi": "Rumah tersedia dalam 2 tipe, 1 dan 2 lantai, dengan opsi cicilan developer maksimal 3 tahun tanpa bank dan tanpa bunga.",
                "Detail Rumah": "-",
                "Developer": "Rajata",
                "Bank yang Bekerjasama": "-",
                "Image Path": r"C:\Users\arche\0(python VISUAL STUDIO CODE)\Property\15.jpg"
            },
             {
                "Nama": "Perumahan Green Residence Sudiang",
                "Harga": "Mulai Rp 700.000.000",
                "Lokasi": "Sudiang, Makassar",
                "Deskripsi": " Kawasan ramah lingkungan dengan fasilitas taman hijau dan sistem cluster.",
                "Detail Rumah": "Rumah 1 lantai, 2 kamar tidur, 1 kamar mandi, luas tanah 72 m².",
                "Developer": "GreenLand Developer",
                "Bank yang Bekerjasama": "Bank Mandiri, BNI",
                "Image Path": r"C:\Users\arche\0(python VISUAL STUDIO CODE)\Property\16.jpg"
            },
            {
                "Nama": "Perumahan Taman Sari Makassar",
                "Harga": "Mulai Rp 1.200.000.000",
                "Lokasi": "Tamalanrea, Makassar",
                "Deskripsi": "Perumahan dengan konsep modern minimalis, dilengkapi dengan fasilitas keamanan 24 jam dan taman bermain anak.",
                "Detail Rumah": "Rumah 2 lantai, 3 kamar tidur, 2 kamar mandi, luas tanah 90 m².",
                "Developer": "PT. Taman Sari Makassar",
                "Bank yang Bekerjasama": "BCA, BRI",
                "Image Path": r"C:\Users\arche\0(python VISUAL STUDIO CODE)\Property\17.jpg"
            },
            
             {
                "Nama": "Perumahan Bukit Baruga Antang",
                "Harga": "Mulai Rp 900.000.000",
                "Lokasi": "Antang, Makassar",
                "Deskripsi": "Perumahan dengan lingkungan asri,",
                "Detail Rumah": "-",
                "Developer": "Bukit Baruga",
                "Bank yang Bekerjasama": "BCA",
                "Image Path": r"C:\Users\arche\0(python VISUAL STUDIO CODE)\Property\18.jpg"
            },
             
            
        ]



        self.checkboxes = []  # List to hold checkbox variables




        for property in properties:
            # Create a frame for each property
            property_frame = ctk.CTkFrame(scrollable_frame)
            property_frame.pack(fill='x', padx=5, pady=5)



            checkbox_var = ctk.IntVar()  # Variabel untuk menyimpan status checkbox
            checkbox = ctk.CTkCheckBox(property_frame, variable=checkbox_var)
            checkbox.grid(row=0, column=0, padx=10)
            self.checkboxes.append((checkbox_var, property_frame))  # Simpan variabel dan frame




            img_path = property.get("Image Path")
            # Load and display the property image
            img_path = property["Image Path"]
            if img_path:  # Check if img_path is not None
                img = Image.open(img_path)
                img = img.resize((400, 400), Image.LANCZOS)  # Resize as needed
                img_photo = ImageTk.PhotoImage(img)



        # Create labels for the image and text
                image_label = ctk.CTkLabel(property_frame, image=img_photo)
                image_label.image = img_photo  # Keep a reference to avoid garbage collection
                image_label.grid(row=0, column=1, padx=10)






            # Create a frame for text information
            text_frame = ctk.CTkFrame(property_frame)
            text_frame.grid(row=0, column=2, padx=10)

            # Add property details to the text frame
            ctk.CTkLabel(text_frame, text="Nama: ", font=("Arial", 14)).grid(row=0, column=0, sticky="w")
            ctk.CTkLabel(text_frame, text=property["Nama"], font=("Arial", 14)).grid(row=0, column=1, sticky="w")

            ctk.CTkLabel(text_frame, text="Harga: ", font=("Arial", 14)).grid(row=1, column=0, sticky="w")
            ctk.CTkLabel(text_frame, text=property["Harga"], font=("Arial", 14)).grid(row=1, column=1, sticky="w")

            ctk.CTkLabel(text_frame, text="Lokasi: ", font=("Arial", 14)).grid(row=2, column=0, sticky="w")
            ctk.CTkLabel(text_frame, text=property["Lokasi"], font=("Arial", 14)).grid(row=2, column=1, sticky="w")

            ctk.CTkLabel(text_frame, text="Deskripsi: ", font=("Arial", 14)).grid(row=3, column=0, sticky="w")
            ctk.CTkLabel(text_frame, text=property["Deskripsi"], font=("Arial", 12), text_color="gray").grid(row=3, column=1, sticky="w")

            ctk.CTkLabel(text_frame, text="Detail Rumah: ", font=("Arial", 14)).grid(row=4, column=0, sticky="w")
            ctk.CTkLabel(text_frame, text=property["Detail Rumah"], font=("Arial", 12), text_color="gray").grid(row=4, column=1, sticky="w")

            ctk.CTkLabel(text_frame, text="Developer: ", font=("Arial", 14)).grid(row=5, column=0, sticky="w")
            ctk.CTkLabel(text_frame, text=property["Developer"], font=("Arial", 12), text_color="gray").grid(row=5, column=1, sticky="w")

            ctk.CTkLabel(text_frame, text="Bank yang Bekerjasama: ", font=("Arial", 14)).grid(row=6, column=0, sticky="w")
            ctk.CTkLabel(text_frame, text=property["Bank yang Bekerjasama"], font=("Arial", 12), text_color="gray").grid(row=6, column=1, sticky="w")

            delete_button = ctk.CTkButton(property_frame, text="Hapus Listingan", command=lambda frame=property_frame: self.delete_property(frame))
            delete_button.grid(row=0, column=0)  # Tempatkan tombol hapus di kolom ke-3





        
        # Back button to return to the dashboard
         # Back button to return to the dashboard
        ctk.CTkButton(self, text="Kembali ke Dashboard", command=lambda: controller.show_frame("SalesDashboardFrame")).pack(pady=10)


    def delete_property(self, property_frame):
        property_frame.destroy()  # Menghapus frame properti dari tampilan
# Fungsi untuk menghapus properti
    def delete_selected_properties(self):
        for delete_button, property_frame in self.checkboxes:
            if delete_button.get() == 1:  # If checkbox is checked
                property_frame.destroy()  # Remove the property frame from display

# Membuat scrollable frame
            scrollable_frame = ctk.CTkScrollableFrame(master=app)
            scrollable_frame.pack(expand=True, fill='both', padx=20, pady=20)










if __name__ == "__main__":
    app = PropertyApp()
    app.mainloop()





#vin-vin,vincent-vincent





#26 frame



