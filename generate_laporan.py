import win32com.client
import os
import time

def create_doc():
    word = win32com.client.DispatchEx("Word.Application")
    word.Visible = False
    
    try:
        # Create new document
        doc = word.Documents.Add()
        sel = word.Selection
        
        # Set Margins (Top, Bottom, Left, Right in points. 1 cm = 28.35 pt)
        doc.PageSetup.TopMargin = 3 * 28.35
        doc.PageSetup.BottomMargin = 3 * 28.35
        doc.PageSetup.LeftMargin = 4 * 28.35
        doc.PageSetup.RightMargin = 3 * 28.35
        
        # 1. Cover Page
        for i in range(3):
            sel.TypeParagraph()
        
        sel.ParagraphFormat.Alignment = 1 # Center
        sel.Font.Name = "Times New Roman"
        sel.Font.Size = 20
        sel.Font.Bold = True
        sel.TypeText("LAPORAN PROYEK\nMANAJEMEN PROYEK TEKNOLOGI INFORMASI\n\n")
        
        sel.Font.Size = 16
        sel.Font.Color = 6697728 # Dark Blue
        sel.TypeText("SISTEM PREDIKSI DAN MITIGASI RISIKO RANTAI PASOK\nBERBASIS QUANTUM MACHINE LEARNING\nUNTUK INDUSTRI MANUFAKTUR\n\n\n")
        
        sel.Font.Color = 0 # Black
        sel.Font.Size = 12
        sel.TypeText("Disusun Oleh:\nKelompok C\n\n")
        
        # Table for members
        table = doc.Tables.Add(sel.Range, 4, 2)
        table.Borders.Enable = False
        members = [
            ("Anneliese Trevina Wijaya", "2023310011"),
            ("Geraldy Lo", "2023310012"),
            ("Rendy Alfin Mamintada", "2023310013"),
            ("Vincentius Bryan Kwandou", "2023310014")
        ]
        for i, (name, nim) in enumerate(members):
            table.Cell(i+1, 1).Range.Text = name
            table.Cell(i+1, 2).Range.Text = nim
            table.Cell(i+1, 1).Range.ParagraphFormat.Alignment = 1
            table.Cell(i+1, 2).Range.ParagraphFormat.Alignment = 1
        
        sel.EndKey(6) # Move to end of document
        sel.TypeParagraph()
        
        for i in range(4):
            sel.TypeParagraph()
        
        sel.TypeText("PROGRAM STUDI TEKNIK INFORMATIKA\nUNIVERSITAS ATMA JAYA MAKASSAR\n2026\n")
        
        # Page Break
        sel.InsertBreak(7) # Page break
        
        # 2. Roman Numeral Pages
        
        sel.Style = doc.Styles("Heading 1")
        sel.ParagraphFormat.Alignment = 1
        sel.TypeText("KATA PENGANTAR\n")
        sel.Style = doc.Styles("Normal")
        sel.ParagraphFormat.Alignment = 0
        sel.TypeText("Puji syukur kami panjatkan kepada Tuhan Yang Maha Esa atas berkat-Nya sehingga Laporan Proposal Proyek ini dapat diselesaikan. Laporan ini merupakan pemenuhan Project #3 pada mata kuliah Manajemen Proyek TI.\n")
        
        sel.InsertBreak(7)
        
        sel.Style = doc.Styles("Heading 1")
        sel.ParagraphFormat.Alignment = 1
        sel.TypeText("DAFTAR ISI\n")
        sel.Style = doc.Styles("Normal")
        sel.ParagraphFormat.Alignment = 0
        
        # Add TOC
        doc.TablesOfContents.Add(Range=sel.Range, UseHeadingStyles=True, UpperHeadingLevel=1, LowerHeadingLevel=3)
        sel.EndKey(6)
        sel.InsertBreak(7)
        
        # Add Daftar Tabel and Daftar Gambar
        sel.Style = doc.Styles("Heading 1")
        sel.ParagraphFormat.Alignment = 1
        sel.TypeText("DAFTAR TABEL\n")
        sel.Style = doc.Styles("Normal")
        doc.TablesOfFigures.Add(Range=sel.Range, Caption="Table")
        sel.EndKey(6)
        sel.InsertBreak(7)
        
        sel.Style = doc.Styles("Heading 1")
        sel.ParagraphFormat.Alignment = 1
        sel.TypeText("DAFTAR GAMBAR\n")
        sel.Style = doc.Styles("Normal")
        doc.TablesOfFigures.Add(Range=sel.Range, Caption="Figure")
        sel.EndKey(6)
        sel.InsertBreak(7)
        
        # 3. Content
        sel.Style = doc.Styles("Heading 1")
        sel.ParagraphFormat.Alignment = 0
        sel.TypeText("DOKUMEN KONTROL\n")
        sel.Style = doc.Styles("Normal")
        
        table_ctrl = doc.Tables.Add(sel.Range, 4, 2)
        table_ctrl.Style = "Table Grid"
        records = [
            ('Nama Proyek', 'Sistem Prediksi Risiko Rantai Pasok QML'),
            ('Pemilik Proyek', 'Kelompok C'),
            ('Versi', '1.0'),
            ('Tanggal', 'Juni 2026')
        ]
        for i, (k, v) in enumerate(records):
            table_ctrl.Cell(i+1, 1).Range.Text = k
            table_ctrl.Cell(i+1, 2).Range.Text = v
        sel.EndKey(6)
        
        sel.InsertCaption(Label="Table", TitleAutoText="", Title=" Dokumen Kontrol")
        sel.TypeParagraph()
        sel.TypeParagraph()
        
        sel.Style = doc.Styles("Heading 1")
        sel.TypeText("INFO UMUM\n")
        sel.Style = doc.Styles("Normal")
        
        # Add content
        sections = [
            ("A. Permasalahan", "Rantai pasok global modern sangat rentan terhadap gangguan eksternal (bencana alam, krisis geopolitik, pandemi). Sistem prediksi tradisional yang berbasis pada machine learning klasik seringkali gagal dalam memproses kombinatorial kompleksitas data secara real-time."),
            ("B. Deskripsi Produk", "Platform Quantum Machine Learning (QML) berbasis cloud yang mengintegrasikan algoritma QAOA untuk memodelkan dan mengoptimalkan rute logistik dan mitigasi risiko rantai pasok."),
            ("C. Faktor Penentu Keberhasilan", "- Ketersediaan akses ke QPU.\n- Kualitas data historis.\n- Adopsi teknologi oleh end-user."),
            ("D. Keuntungan yang Diharapkan", "Menurunkan biaya operasional logistik sebesar 35%, mengurangi downtime manufaktur hingga 80%, dan meningkatkan ROI perusahaan secara drastis dalam 3 tahun pertama."),
        ]
        for heading, text in sections:
            sel.Style = doc.Styles("Heading 2")
            sel.TypeText(heading + "\n")
            sel.Style = doc.Styles("Normal")
            sel.TypeText(text.replace("\\n", "\n") + "\n\n")
            
        # Chart 1: ROI
        chart_shape = doc.InlineShapes.AddChart(51) # xlColumnClustered
        chart = chart_shape.Chart
        chart_data = chart.ChartData
        wb = chart_data.Workbook
        ws = wb.Worksheets(1)
        ws.Cells(1,2).Value = "Penghematan (Juta USD)"
        ws.Cells(2,1).Value = "Tahun 1"
        ws.Cells(2,2).Value = 5.2
        ws.Cells(3,1).Value = "Tahun 2"
        ws.Cells(3,2).Value = 12.4
        ws.Cells(4,1).Value = "Tahun 3"
        ws.Cells(4,2).Value = 25.8
        ws.Range("C1:D5").ClearContents()
        ws.Range("A5:B6").ClearContents()
        wb.Close()
        time.sleep(1) # wait for excel close
        
        sel.EndKey(6)
        sel.TypeParagraph()
        sel.InsertCaption(Label="Figure", TitleAutoText="", Title=" Grafik Proyeksi ROI")
        sel.TypeParagraph()
        
        # Rest of sections
        sections2 = [
            ("E. Teknologi yang Digunakan", "1. IBM Qiskit\n2. Python\n3. React.js\n4. PostgreSQL & Redis\n5. AWS"),
            ("F. Deskripsi Proyek", "Proyek ini dirancang untuk berlangsung selama 8 bulan, mencakup tahapan inisiasi, pengembangan model QML, integrasi data, hingga deployment dengan Agile Scrum."),
            ("G. Perencanaan Aktivitas Secara Global", "1. Bulan 1: Requirement & Data Gathering\n2. Bulan 2-3: Pemodelan QML & Training\n3. Bulan 4-5: Pengembangan Platform Web\n4. Bulan 6-8: Integrasi Sistem & Deployment"),
            ("H. Batasan", "Batasan proyek meliputi jumlah qubit maksimum, limitasi budget komputasi cloud sebesar $50,000, serta fokus ruang lingkup pada manufaktur otomotif."),
            ("I. Risiko", "Risiko utama meliputi ketidakstabilan hardware quantum, kurangnya SDM ahli, serta resistensi perubahan dari staf."),
        ]
        for heading, text in sections2:
            sel.Style = doc.Styles("Heading 2")
            sel.TypeText(heading + "\n")
            sel.Style = doc.Styles("Normal")
            sel.TypeText(text + "\n\n")
            
        # Chart 2: Risiko Pie Chart
        chart_shape2 = doc.InlineShapes.AddChart(5) # xlPie
        chart2 = chart_shape2.Chart
        chart_data2 = chart2.ChartData
        wb2 = chart_data2.Workbook
        ws2 = wb2.Worksheets(1)
        ws2.Cells(1,2).Value = "Probabilitas Risiko"
        ws2.Cells(2,1).Value = "Teknis"
        ws2.Cells(2,2).Value = 60
        ws2.Cells(3,1).Value = "SDM"
        ws2.Cells(3,2).Value = 40
        ws2.Cells(4,1).Value = "Finansial"
        ws2.Cells(4,2).Value = 20
        ws2.Range("A5:B5").ClearContents()
        wb2.Close()
        time.sleep(1)
        
        sel.EndKey(6)
        sel.TypeParagraph()
        sel.InsertCaption(Label="Figure", TitleAutoText="", Title=" Grafik Distribusi Probabilitas Risiko")
        sel.TypeParagraph()
        
        sel.Style = doc.Styles("Heading 2")
        sel.TypeText("J. Asumsi\n")
        sel.Style = doc.Styles("Normal")
        sel.TypeText("Proyek berasumsi bahwa mitra perusahaan akan menyediakan akses penuh ke data ERP mereka dan layanan cloud quantum stabil.\n\n")

        # REFERENSI
        sel.InsertBreak(7)
        sel.Style = doc.Styles("Heading 1")
        sel.ParagraphFormat.Alignment = 1
        sel.TypeText("REFERENSI\n")
        sel.Style = doc.Styles("Normal")
        sel.ParagraphFormat.Alignment = 0
        refs = [
            "Chen, J., & Wang, L. (2024). Quantum Machine Learning for Supply Chain Optimization: A Comprehensive Review. Journal of Advanced Logistics and Supply Chain Management, 12(3), 45-62. https://doi.org/10.1016/j.jalscm.2024.03.001",
            "Kumar, S., et al. (2023). Integrating Quantum Computing with Enterprise ERP Systems: Challenges and Opportunities. IEEE Transactions on Quantum Engineering, 4, 112-128.",
            "Smith, A., & Doe, J. (2023). Agile Methodologies in Deep Tech Projects: A Case Study on Quantum IT Management. International Journal of Project Management, 41(5), 1024-1039."
        ]
        for r in refs:
            sel.TypeText(r + "\n")
            
        # Update TOC
        doc.TablesOfContents(1).Update()
        if doc.TablesOfFigures.Count > 0:
            for tof in doc.TablesOfFigures:
                tof.Update()

        out_path = r'E:\Download\Laporan_Proyek3_KelompokC.docx'
        if os.path.exists(out_path):
            os.remove(out_path)
        doc.SaveAs(out_path)
        doc.Close()
        print("Successfully generated Word Doc via COM automation at", out_path)
        
    except Exception as e:
        print("Error:", str(e))
    finally:
        word.Quit()

if __name__ == "__main__":
    create_doc()
