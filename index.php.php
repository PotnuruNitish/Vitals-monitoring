<!DOCTYPE html>
<html>
<head>
    <title>RC_THD</title>
    <link rel="shortcut icon" href="images/Layer 1.png" />
    <style>
        body{
            text-align: center;
            box-align: center;
            background-image: url('images/czNmcy1wcml2YXRlL3Jhd3BpeGVsX2ltYWdlcy93ZWJzaXRlX2NvbnRlbnQvbHIvcm0zNzNiYXRjaDE1LWJnLTExLmpwZw.webp');
            background-repeat: no-repeat;
            background-size: cover;
        }
        #dataDisplay {
            overflow-y: auto;
            height: 300px; /* Adjust as needed */
            padding: 20px;
            width: 50%;
            border: 1px solid #fff;
            background-color: transparent;
            font-family: Arial, sans-serif;
            text-align: center;
            color:white
        }
        div{
            align-items: center;
            display: flex;
            margin-left: 23%;
            margin-top: 10%;
        }
        h1{
            color:white;
            text-transform: uppercase;
        }
        Button{
            margin-top: 5%;
            background: white;
            color:green;
            font-size: 20px;
            border-radius: 10px;
            font-weight: bold;
        }
        Button:hover{
            color: white;
            background: navy;
        }
    </style>
</head>
<body>
    <h1 >Health Dashboard</h1>

    <button id="connectButton" onclick="connectToArduino()">Connect to Device</button>

    <div id="dataDisplay"></div>

    <script>
        let port;
        let reader; 
        let isConnected = false; 
        async function connectToArduino() {
            try {
                port = await navigator.serial.requestPort();
                await port.open({ baudRate: 115200 });
                reader = port.readable.getReader();
                document.getElementById("dataDisplay").textContent = "Connected";
                document.getElementById("connectButton").style.display = "none"; // Hide the button
                isConnected = true;
                readFromArduino();
            } catch (error) {
                console.error(error);
                document.getElementById("dataDisplay").textContent = "Error: " + error.message;
            }
        }

        async function readFromArduino() {
            try {
                while (true) {
                    const { value, done } = await reader.read();

                    if (done) {
                        console.log("Stream has been closed by Arduino.");
                        break;
                    }

                    const data = new TextDecoder().decode(value);

                    // Replace newline characters with <br> tag
                    const formattedData = data.replace(/\n/g, "<br>");

                    document.getElementById("dataDisplay").innerHTML += formattedData; // Append data

                    // Auto scroll to the bottom
                    document.getElementById("dataDisplay").scrollTop = document.getElementById("dataDisplay").scrollHeight;
                }
            } catch (error) {
                console.error(error);
                document.getElementById("dataDisplay").textContent = "Error: " + error.message;
            }
        }
    </script>
</body>
</html>
