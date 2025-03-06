<!DOCTYPE html>
<html class="h-full bg-gray-100" lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
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
        <div class="flex gap-[20px] flex-row flex-nowrap justify-start items-stretch content-stretch">
          <div class="grow">
            <form class="max-w-sm mx-auto">
              <p class="py-4 font-bold text-2xl">Encryption</p>
              <div class="mb-5">
                <label for="plain-text" class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray">Plain Text</label>
                <input type="text" id="plain-text-enc" class="block w-full p-2 text-gray-900 border border-white-300 rounded-lg bg-white-50 text-sm" placeholder="Plain Text">
              </div>
              <div class="mb-5">
                  <label for="secret-key-aes" class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray">Secret Key</label>
                  <input type="text" id="secret-key-aes-enc" class="block w-full p-2 text-gray-900 border border-white-300 rounded-lg bg-white-50 text-sm" placeholder="Password">
              </div>
              <div class="bg-white p-6 mb-5 rounded-lg shadow-md w-80">
                <label for="imageUpload" class="block text-gray-700 font-semibold mb-2">Upload Gambar untuk LSB</label>
        
                <div class="relative border-2 border-dashed border-gray-300 rounded-lg p-4 flex flex-col items-center justify-center cursor-pointer hover:bg-gray-50">
                    <input type="file" id="imageupload-enc" accept="image/*" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer" onchange="previewImage(event)">
                    <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"></path>
                    </svg>
                    <p class="text-gray-500 text-sm mt-2">Klik untuk upload</p>
                </div>
        
                <div id="previewContainer" class="mt-4 hidden">
                    <img id="previewImage" class="w-full rounded-lg shadow-md">
                </div>
              </div>
              <button type="submit" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Encrypt</button>
              
            </form>
          </div>
          <div class="grow">
            <form class="max-w-sm mx-auto">
              <p class="py-4 font-bold text-2xl">Decryption</p>
              <div class="mb-5">
                  <label for="plain-text" class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray">Plain Text</label>
                  <input type="text" id="plain-text-dec" class="block w-full p-2 text-gray-900 border border-white-300 rounded-lg bg-white-50 text-sm" placeholder="Plain Text">
              </div>
              <div class="mb-5">
                <label for="secret-key-aes" class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray">Secret Key</label>
                  <input type="text" id="secret-key-aes-dec" class="block w-full p-2 text-gray-900 border border-white-300 rounded-lg bg-white-50 text-sm" placeholder="Password">
            </div>
            <div class="bg-white p-6 mb-5 rounded-lg shadow-md w-80">
              <label for="imageUpload" class="block text-gray-700 font-semibold mb-2">Upload Gambar LSB</label>
      
              <div class="relative border-2 border-dashed border-gray-300 rounded-lg p-4 flex flex-col items-center justify-center cursor-pointer hover:bg-gray-50">
                  <input type="file" id="imageupload-dec" accept="image/*" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer" onchange="previewImage(event)">
                  <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                      <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"></path>
                  </svg>
                  <p class="text-gray-500 text-sm mt-2">Klik untuk upload</p>
              </div>
      
              <div id="previewContainer" class="mt-4 hidden">
                  <img id="previewImage" class="w-full rounded-lg shadow-md">
              </div>
            </div>
            <button type="submit" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Decrypt</button>
            </form>
          </div>
        </div>
      </div>
    </main>
  </div>
</body>
<x-footer></x-footer>
</html>