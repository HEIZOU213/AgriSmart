<!DOCTYPE html>
<html>
<head>
    <title>Pembayaran AgriSmart</title>
    <script type="text/javascript"
            src="https://app.sandbox.midtrans.com/snap/snap.js"
            data-client-key="{{ config('services.midtrans.client_key') }}"></script>
</head>
<body>
    <h1>Tagihan: Rp {{ number_format($order->total_price) }}</h1>
    
    <button id="pay-button">Bayar Sekarang</button>

    <script type="text/javascript">
      var payButton = document.getElementById('pay-button');
      payButton.addEventListener('click', function () {
        // Panggil Snap Token yang dikirim dari Controller
        window.snap.pay('{{ $snapToken }}', {
          onSuccess: function(result){
            alert("pembayaran sukses!");
            console.log(result);
            window.location.href = '/dashboard'; // Redirect setelah sukses
          },
          onPending: function(result){
            alert("menunggu pembayaran!"); console.log(result);
          },
          onError: function(result){
            alert("pembayaran gagal!"); console.log(result);
          }
        });
      });
    </script>
</body>
</html>