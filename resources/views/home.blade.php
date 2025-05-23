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

        <div class="block gap-[20px] flex-wrap flex-row justify-start items-start">
            <div class="w-full">Advanced Encryption Standard (AES) is a symmetric cryptographic algorithm widely used to secure digital data. It encrypts data in 128-bit, and is known for its speed and strong security in applications such as file encryption, network communication, and data protection systems. Meanwhile, the Least Significant Bit (LSB) is a technique used in digital steganography to hide secret information within digital media (such as images or audio) by altering the least significant bits of the media's data. These changes are typically imperceptible to the human senses but can securely embed hidden information.</div>
        </div>
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
              <button type="submit"  class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Encrypt</button>
            
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
                      <button type="button" class="mt-2 text-red-500 hover:text-red-700" onclick="removeImage('imageupload-dec', 'previewContainerDec')">Hapus Gambar</button>
                  </div>
              </div>
              <button type="submit" /onclick="openModal('Decrypted')" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Decrypt</button>
            </form>
          </div>
        </div>
        </div>
      </div>
      

<!-- Modal toggle -->

                  <!-- Main modal -->
                  <div class="relative z-10 hidden" id="default-modal"  aria-labelledby="modal-title" role="dialog" aria-modal="true">
                  
                    <div class="fixed inset-0 bg-gray-500/75 transition-opacity" aria-hidden="true"></div>
                  
                    <div class="fixed inset-0 z-10 w-screen overflow-y-auto">
                      <div class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0">
                        <!--
                          Modal panel, show/hide based on modal state.
                  
                          Entering: "ease-out duration-300"
                            From: "opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                            To: "opacity-100 translate-y-0 sm:scale-100"
                          Leaving: "ease-in duration-200"
                            From: "opacity-100 translate-y-0 sm:scale-100"
                            To: "opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                        -->
                        <div class="relative transform overflow-hidden rounded-lg bg-white text-left shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-lg">
                          <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                            <div class="sm:flex sm:items-start">
                              <div class="mx-auto flex size-12 shrink-0 items-center justify-center rounded-full bg-red-100 sm:mx-0 sm:size-10">
                                <svg class="size-6 text-red-600" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true" data-slot="icon">
                                  <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126ZM12 15.75h.007v.008H12v-.008Z" />
                                </svg>
                              </div>
                              <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                                <h3 class="text-base font-semibold text-gray-900" id="modal-title">Encrypted Success</h3>
                                <div class="mt-2">
                                  <p class="text-sm text-gray-500">Are you sure you want to deactivate your account? All of your data will be permanently removed. This action cannot be undone.</p>
                                </div>
                              </div>
                            </div>
                          </div>
                          <div class="bg-gray-50 px-4 py-3 sm:flex sm:flex-row-reverse sm:px-6">
                            <button id="btn-d" type="button" class="inline-flex w-full justify-center rounded-md bg-blue-600 px-3 py-2 text-sm font-semibold text-white shadow-xs hover:bg-blue-500 sm:ml-3 sm:w-auto">Download</button>
                            <button type="button" onclick="closeModal()" class="mt-3 inline-flex w-full justify-center rounded-md bg-white px-3 py-2 text-sm font-semibold text-gray-900 shadow-xs ring-1 ring-gray-300 ring-inset hover:bg-gray-50 sm:mt-0 sm:w-auto">Cancel</button>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                  
              

  
    </main>
  </div>

  
  {{-- script untuk proses ajax --}}
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script>
      function openModal(title = "") {
          const modal = document.getElementById('default-modal');
          const modalTitle = document.getElementById('modal-title');
          modal.classList.remove('hidden'); // Menampilkan modal
          modal.classList.add('flex'); // Tambahkan flex jika perlu

          if(modalTitle){
            modalTitle.textContent = title;
          }

          const download =document.getElementById('btn-d');

          if(title == 'Decrypted'){
            download.classList.remove('inline-flex');
            download.classList.add('hidden');
          }else{
            download.classList.add('inline-flex');
            download.classList.remove('hidden');
          }

      }

      function closeModal() {
          const modal = document.getElementById('default-modal');
          modal.classList.add('hidden'); // Sembunyikan modal
          modal.classList.remove('flex'); // Hapus flex jika ditambahkan
      }

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
                    // alert('Error: ' + xhr.responseText);
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
        fileInputContainer.style.display = 'flex';
    }
}
</script>
</body>
<x-footer></x-footer>
</html>