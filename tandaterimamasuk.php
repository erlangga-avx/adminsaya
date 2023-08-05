<?php
require 'function.php';
require 'cek.php';
?>

<!DOCTYPE html>
<html>

<head>
    <title>GRAND Fotocopy Gambut</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.2.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.2/css/dataTables.bootstrap5.min.css">
    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script src="https://cdn.datatables.net/1.13.2/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.2/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.4.0/jspdf.umd.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.3.2/html2canvas.min.js"></script>
</head>

<body>
    <div class="container" id="daerahprint" style="text-align: left;">
        <h2>GRAND Fotocopy Gambut</h2>
        <h4>Surat Tanda Terima Barang</h4>
        <?php
        // Get supplier information based on the idsupplier from the URL parameter
        $idsupplier = $_GET['id'];
        $get_supplier = mysqli_query($conn, "SELECT * FROM supplier WHERE idsupplier='$idsupplier'");
        $supplier_data = mysqli_fetch_assoc($get_supplier);
        $nama_supplier = $supplier_data['namasupplier'];

        // Get transaction details based on the idtransaksi from the URL parameter
        $idtransaksi = $_GET['id'];
        $get_transaksi = mysqli_query($conn, "SELECT * FROM transaksimasuk WHERE idtransaksi='$idtransaksi'");
        $transaksi_data = mysqli_fetch_assoc($get_transaksi);
        $kodetransaksi = $transaksi_data['kodetransaksi'];
        $tanggal = $transaksi_data['tanggal'];
        $penerima = $transaksi_data['penerima'];

        // Get all items from the transaction with the specified idtransaksi and idsupplier
        $query = "SELECT * FROM masuk m 
                  JOIN stok s ON s.idbarang = m.idbarang 
                  WHERE m.idtransaksi='$idtransaksi' AND m.idsupplier='$idsupplier'";
        $ambildatamasuk = mysqli_query($conn, $query);
        ?>

        <p>Kepada : <?php echo $nama_supplier; ?></p>
        <p>Nomor Transaksi : <?php echo $kodetransaksi; ?></p>
        <p>Pada hari ini <?php echo $tanggal; ?>, telah menerima barang sebagai berikut:</p>
        <table class="table table-borderless">
            <thead>
                <tr>
                    <th>Qty</th>
                    <th>Satuan</th>
                    <th>Nama Barang</th>
                </tr>
            </thead>
            <tbody>
                <?php
                while ($data = mysqli_fetch_array($ambildatamasuk)) {
                    $qty = $data['qty'];
                    $satuan = $data['satuan'];
                    $namabarang = $data['namabarang'];
                ?>
                    <tr>
                        <td><?php echo $qty; ?></td>
                        <td><?php echo $satuan; ?></td>
                        <td><?php echo $namabarang; ?></td>
                    </tr>
                <?php
                }
                ?>
            </tbody>
        </table>

        <p>Demikian surat ini dibuat, atas perhatiannya, kami ucapkan terima kasih.</p>
        <br>
        <br>
        <div style="display: flex;">
            <div style="flex: 1; text-align: left;">
                <p>Penerima Barang</p>
                <br>
                <br>
                <br>
                <p><?php echo $penerima; ?></p>
            </div>
            <div style="flex: 1; text-align: left;">
                <p>Pengirim Barang</p>
                <br>
                <br>
                <br>
                <p>_____________________________</p>
            </div>
        </div>

    </div>
    <button onclick="exportAsPDF()">Export PDF</button>
    <button onclick="printContent()">Print</button>
    <script>
        function exportAsPDF() {
            // Your existing export to PDF code here
        }

        function printContent() {
            const element = document.getElementById('daerahprint');

            // Use html2canvas to capture the content as an image
            html2canvas(element).then(canvas => {
                const imgData = canvas.toDataURL('image/png');

                // Create an empty image element to add the captured image
                const img = new Image();
                img.src = imgData;

                // Create a new window to display the captured content
                const printWindow = window.open('', '', 'width=800, height=600');
                printWindow.document.open();
                printWindow.document.write('<html><head><title>Print</title></head><body>');
                printWindow.document.write('<img src="' + img.src + '" style="width:100%; height:auto;">');
                printWindow.document.write('</body></html>');
                printWindow.document.close();

                // Trigger the browser's print dialog
                printWindow.print();
                printWindow.close();
            });
        }
    </script>

    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script src="https://cdn.datatables.net/1.13.2/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.3.4/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.3.4/js/buttons.flash.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.3.4/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.3.4/js/buttons.print.min.js"></script>
    <style>
        @media print {
            body * {
                visibility: hidden;
            }

            #daerahprint,
            #daerahprint * {
                visibility: visible;
            }

            #daerahprint {
                position: absolute;
                left: 0;
                top: 0;
            }
        }
    </style>
</body>

</html>