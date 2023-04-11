<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="dist/output.css" />
    <title>musicshow</title>
</head>
<body class="bg-gray-300">
    <div class="container mx-auto mt-32">
        @if(session()->has('error')) {{session()->get('error')}} @endif
        <div class="md:w-6/12 mx-5 bg-white shadow-lg px-10 py-5 rounded-lg flex flex-col justify-center md:mx-auto">
            <!-- <h1 class="text-red-500 font-bold uppercase text-2xl text-center mb-8">Make Payment</h1> -->
            <div class="flex flex-col justify-center">
            <form action="/payconfig" class="flex flex-col gap-4" id="makePaymentForm">
                @csrf
       
                    <input type="text" placeholder="Full name" name="name" class="border-b border-gray-400 px-2 py-1 mb-3 w-1/2 mx-auto" id="name">
                    @error('name')
                    <p>please provide username</p>
                    @enderror

               
                  
                    <input type="email" placeholder="Email address" name="email" class="border-b border-gray-400 px-2 py-1 mb-3 w-1/2 mx-auto" id="email">
                    @error('email')
                    <p>please provide username</p>
                    @enderror
             
                   
                    <input type="number" placeholder="phone number" name="phone_number" class="border-b border-gray-400 px-2 py-1 mb-3 w-1/2 mx-auto" id="phone_number">
                     @error('phone_number')
                    <p>please provide username</p>
                    @enderror
          
                <button name="submit" class="w-1/2 mx-auto mt-4 text-white bg-blue-600 rounded-lg px-3 py-2 shadow-md hover:bg-blue-400 transition ease-out duration-500" type="submit">Buy Ticket</button>
            </form>
</body>
</html>