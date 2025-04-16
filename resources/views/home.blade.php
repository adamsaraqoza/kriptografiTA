<!DOCTYPE html>
<html class="h-full bg-gray-100" lang="en">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}"> <!-- CSRF Token -->
    @vite('resources/css/app.css')
    <link rel="stylesheet" href="https://rsms.me/inter/inter.css" />
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <title>Kriptografi</title>
</head>
<body class="h-full">
   
<div class="min-h-full">
    <x-navbar></x-navbar>
  
    <x-header></x-header>
    <main>
      <div class="mx-auto max-w-7xl px-4 py-6 sm:px-6 lg:px-8">
        <div class="block max-w-full p-6 bg-white border border-gray-200 rounded-lg shadow-sm">
        <div class="flex gap-[20px] flex-row flex-nowrap justify-start items-stretch content-stretch">
          <div class="grow">
            
            <form id="encryptionForm" class="max-w-sm mx-auto">
              <p class="py-4 font-bold text-2xl">Encryption</p>
              <div class="mb-5">
                  <label for="plain-text-enc" class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray">Plain Text</label>
                  <textarea id="plain-text-enc" name="plain_text" class="block w-full p-2 text-gray-900 border border-white-300 rounded-lg bg-white-50 text-sm" placeholder="Plain Text" rows="3"></textarea>
              </div>
              <div class="mb-5">
                  <label for="secret-key-aes-enc" class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray">Secret Key - AES</label>
                  <input type="text" id="secret-key-aes-enc" name="secret_key_aes" class="block w-full p-2 text-gray-900 border border-white-300 rounded-lg bg-white-50 text-sm" placeholder="Password">
              </div>
              <div class="mb-5">
                  <label for="secret-key-lsb-enc" class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray">Secret Key - LSB</label>
                  <input type="text" id="secret-key-lsb-enc" name="secret_key_lsb" class="block w-full p-2 text-gray-900 border border-white-300 rounded-lg bg-white-50 text-sm" placeholder="Password">
              </div>
              <div class="bg-white p-6 mb-5 rounded-lg shadow-md w-full">
                  <label for="imageupload-enc" class="block text-gray-700 font-semibold mb-2">Upload Gambar untuk LSB</label>
                  <div class="relative border-2 border-dashed border-gray-300 rounded-lg p-4 flex flex-col items-center justify-center cursor-pointer hover:bg-gray-50">
                      <input type="file" id="imageupload-enc" name="image" accept="image/*" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer" onchange="previewImage(event, 'previewContainerEnc')">
                      <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                          <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"></path>
                      </svg>
                      <p class="text-gray-500 text-sm mt-2">Klik untuk upload</p>
                  </div>
                  <div id="previewContainerEnc" class="mt-4 hidden">
                    <img id="previewImageEnc" class="w-full rounded-lg shadow-md">
                    <button type="button" class="mt-2 text-red-500 hover:text-red-700" onclick="removeImage('imageupload-enc', 'previewContainerEnc')">Hapus Gambar</button>
                </div>
                </div>
               
                
              <button type="submit" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Encrypt</button>
            
            </form>
          
          </div>

          <div class="grow">
            <form id="decryptionForm" class="max-w-sm mx-auto">
              <p class="py-4 font-bold text-2xl">Decryption</p>
              <div class="mb-5">
                  <label for="encrypted-text-dec" class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray">Encrypted Text</label>
                  <textarea id="encrypted-text-dec" name="encrypted_text" class="block w-full p-2 text-gray-900 border border-white-300 rounded-lg bg-white-50 text-sm" placeholder="Encrypted Text" rows="3"></textarea>
              </div>
              <div class="mb-5">
                  <label for="secret-key-aes-dec" class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray">Secret Key - AES</label>
                  <input type="text" id="secret-key-aes-dec" name="secret_key_aes" class="block w-full p-2 text-gray-900 border border-white-300 rounded-lg bg-white-50 text-sm" placeholder="Password">
              </div>
              <div class="bg-white p-6 mb-5 rounded-lg shadow-md w-full">
                  <label for="imageupload-dec" class="block text-gray-700 font-semibold mb-2">Upload Gambar LSB</label>
                  <div class="relative border-2 border-dashed border-gray-300 rounded-lg p-4 flex flex-col items-center justify-center cursor-pointer hover:bg-gray-50">
                      <input type="file" id="imageupload-dec" name="image" accept="image/*" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer" onchange="previewImage(event, 'previewContainerDec')">
                      <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                          <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"></path>
                      </svg>
                      <p class="text-gray-500 text-sm mt-2">Klik untuk upload</p>
                  </div>
                  <div id="previewContainerDec" class="mt-4 hidden">
                      <img id="previewImageDec" class="w-full rounded-lg shadow-md">
                  </div>
              </div>
              <button type="submit" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Decrypt</button>
            </form>
          </div>
        </div>
        </div>
      </div>
    </main>
  </div>
  {{-- script untuk proses ajax --}}
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script>
    $(document).ready(function () {
        // Fungsi untuk preview gambar
        

        // Handle encryption form submission
        $('#encryptionForm').on('submit', function (e) {
            e.preventDefault();

            const formData = new FormData(this);

            $.ajax({
                url: '/encrypt',
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                },
                success: function (response) {
                    if (response.status === 'success') {
                        alert('Enkripsi berhasil!');
                        console.log(response);
                    } else {
                        alert('Terjadi kesalahan: ' + response.message);
                    }
                },
                error: function (xhr) {
                    alert('Error: ' + xhr.responseText);
                },
            });
        });

        // Handle decryption form submission
        $('#decryptionForm').on('submit', function (e) {
            e.preventDefault();

            const formData = new FormData(this);

            $.ajax({
                url: '/decrypt',
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                },
                success: function (response) {
                    if (response.status === 'success') {
                        alert('Dekripsi berhasil!');
                        console.log(response);
                    } else {
                        alert('Terjadi kesalahan: ' + response.message);
                    }
                },
                error: function (xhr) {
                    alert('Error: ' + xhr.responseText);
                },
            });
        });
    });

    // Fungsi untuk menampilkan preview gambar
    function previewImage(event, previewId) {
        const input = event.target; // Input file yang dipilih

        console.log(input)
        const previewContainer = document.getElementById(previewId); // Container untuk preview
        const previewImage = previewContainer.querySelector('img'); // Elemen gambar

        if (input.files && input.files[0]) {
            const reader = new FileReader(); // Membuat objek FileReader

            // Ketika file selesai dibaca
            reader.onload = function (e) {
              console.log("File loaded:", e.target.result); // Debugging
                previewImage.src = e.target.result; // Set sumber gambar ke hasil bacaan
                previewContainer.classList.remove('hidden'); // Tampilkan container preview
                const fileInputContainer = input.closest('.relative'); // Ambil container induk input file
            if (fileInputContainer) {
                fileInputContainer.style.display = 'none';
            }
            };

             // Sembunyikan input file setelah gambar dipilih

            reader.readAsDataURL(input.files[0]); // Baca file sebagai URL data
        } else {
            previewContainer.classList.add('hidden'); // Sembunyikan container jika tidak ada file
        }
    }
    function removeImage(inputId, previewId) {
    const input = document.getElementById(inputId); // Input file
    const previewContainer = document.getElementById(previewId); // Container preview
    const previewImage = previewContainer.querySelector('img'); // Elemen gambar

    // Kosongkan nilai input file
    input.value = '';

    // Reset preview gambar
    previewImage.src = '';
    previewContainer.classList.add('hidden');

    // Tampilkan kembali container input file
    const fileInputContainer = input.closest('.relative'); // Ambil container induk input file
    if (fileInputContainer) {
        fileInputContainer.style.display = 'block';
    }
}
</script>
</body>
<x-footer></x-footer>
</html>