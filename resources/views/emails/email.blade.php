<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Verifique seu E-mail</title>
</head>
<style>

    {/* Tags */}

    html, body {
        height: 100%;
        overflow: hidden;
        background-color: #fdeeda;
    }

    body {
        font-family: gotham, arial, helvetica, sans-serif;
        padding: 0;
        margin: 0 auto !important;
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
    }

    header {
        display: flex;
        align-items: center;
        justify-content: center;
        margin-top: 20px;
    }

    main {
            display: flex;
            justify-content: center; 
            flex-direction: column;
            align-items: center;
            width: 100vw;
        }

    h1, h2, p {
        margin: 0; 
        color: #080402;
    }

    img:nth-child(3) {
        transform: rotate(180deg)
    }


    {/* Class */}

    .container-title__main {
        display: flex;
        justify-content: center; 
        flex-direction: column;
        align-items: center;
        margin: 50px 0 20px 0;
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

    .div-carta__section {
        display: flex;
        justify-content: center; 
        align-items: center;
        position: relative;
        top: 40px;
    }

    .code__container-title {
        width: 250px;
        height: auto;
        background-color: #FFCEE0;
        border-radius: 15px;

        & .h1__code {
            padding: 10px;
            letter-spacing: 5px;
            font-size: 2.5rem;
        }
    }

    .img__main {
        width: 250px;
        height: auto;
    }

    .p__main {
        margin: 10px 0 30px;
        font-size: 18px;
        max-width: 450px;
        text-align: center;
    }
</style>
<body>
    <header> 
        <img src="{{ asset('images/Logo.png') }}" alt="Logo" class="">
    </header>
    <main> 
        <div style=" text-align: center; color: white; width: 100vw;">

        <section class="section__main"> 
            <div class="div-carta__section">
                <img src="{{ asset('images/img-carta.png') }}" alt="Email Icon" class="img__main">
            </div>
                <!-- Título -->
            <div class="div-images__main">
                <img src="{{ asset('images/blossom-flower.png') }}" alt="Flor de Cerejeira" class="img__main">

                <div class="container-title__main"> 
                    <h2>Verify Your Email Account</h2>
        
                <!-- Texto descritivo -->
                <p class="p__main">
                    Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna.
                </p>
                    <div class="code__container-title">
                        <h1 class="h1__code"> 1245642 </h1>
                    </div>
                </div>

                <img src="{{ asset('images/blossom-flower.png') }}" alt="Flor de Cerejeira"  class="img__main">
            </div>
        </section>

        <!-- Botão de verificação -->

    </div>
    </main>

</body>
</html>
