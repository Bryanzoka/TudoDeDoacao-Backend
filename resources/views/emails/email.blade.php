<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Verifique seu E-mail</title>
</head>
<style>
    html, body {
        height: 100%;
        overflow: hidden;
        background-color: #fdeeda;
    }

    body {
        font-family: gotham, arial, helvetica, sans-serif;
        font-size: 18px;
        padding: 0;
        margin: 0 auto !important;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
    }

    main {
            display: flex;
            justify-content: center; 
            flex-direction: column;
            align-items: center;
            width: 100vw;
        }

        .container-title__main {
            display: flex;
            justify-content: center; 
            flex-direction: column;
            align-items: center;
        }

        .section__main {
            display: flex;
            justify-content: center;
            flex-direction: column;
        }

        .div-images__main {
            display: flex;
            justify-content: center; 
            align-items: center;
            gap: 20px;
        }

        img:nth-child(3) {
            transform: rotate(180deg)
        }

        .div-carta__section {
            display: flex;
            justify-content: center; 
            align-items: center;
            position: relative;
            top: 40px;
        }

        .img__main {
            width: 250px;
            height: auto;
        }

        h1 {
                margin: 0; 
                font-size: 24px;
                color: #080402;
        }

        .p__main {
            margin: 10px 0 30px;
            font-size: 16px;
            color: #080402;
            max-width: 450px;
            text-align: center;
        }

</style>
<body>
    <header> 
        logo
    </header>
    <main> 
        <div style="padding: 40px 20px; text-align: center; color: white; width: 100vw;">

        <section class="section__main"> 
            <div class="div-carta__section">
                <img src="{{ asset('images/img-carta.png') }}" alt="Email Icon" class="img__main">
            </div>
                <!-- Título -->
            <div class="div-images__main">
                <img src="{{ asset('images/blossom-flower.png') }}" alt="Email Icon" class="img__main">

                <div class="container-title__main"> 
                    <h1 >Verify Your Email Account</h1>
        
                <!-- Texto descritivo -->
                <p class="p__main">
                    Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna.
                </p>
                </div>

                <img src="{{ asset('images/blossom-flower.png') }}" alt="Email Icon"  class="img__main">
            </div>
        </section>

        <!-- Botão de verificação -->
    </div>
    </main>

    <footer> 
        <!-- Rodapé -->
        <div style="background-color: #f4f4f4; padding: 30px 20px; text-align: center;">
            <!-- Ícones sociais (substitua os hrefs pelos links reais) -->
            <div style="margin-bottom: 15px;">
                <a href="#"><img src="https://img.icons8.com/ios-filled/24/000000/facebook.png" alt="Facebook" style="margin: 0 10px;"></a>
                <a href="#"><img src="https://img.icons8.com/ios-filled/24/000000/instagram-new.png" alt="Instagram" style="margin: 0 10px;"></a>
                <a href="#"><img src="https://img.icons8.com/ios-filled/24/000000/twitter.png" alt="Twitter" style="margin: 0 10px;"></a>
                <a href="#"><img src="https://img.icons8.com/ios-filled/24/000000/pinterest--v1.png" alt="Pinterest" style="margin: 0 10px;"></a>
            </div>

            <!-- Informações de contato -->
            <p style="margin: 5px 0; font-size: 14px; color: #333;">(738) 479-6719</p>
            <p style="margin: 5px 0; font-size: 14px; color: #333;">info@website.com - Simple Pleb</p>
        </div>
    </footer>

</body>
</html>
