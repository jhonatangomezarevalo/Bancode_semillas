<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Banco de Semillas - Mensajes</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <style>
        /* Estilos generales */
        :root {
            --primary-color: #006633;
            --secondary-color: #009933;
            --accent-color: #FFCC00;
            --background-color: #f0f8f0;
            --text-color: #333;
            --light-text-color: #777;
            --hover-color: #004d26;
            --border-color: #ddd;
            --sidebar-width: 250px;
            --content-max-width: 1000px;
        }
        body, html {
            margin: 0;
            padding: 0;
            font-family: 'Poppins', sans-serif;
            background: var(--background-color);
            color: var(--text-color);
            height: 100vh;
            overflow: hidden;
        }
        .container {
            display: flex;
            height: 100vh;
            width: 100%;
        }
        .sidebar {
            width: var(--sidebar-width);
            background: var(--primary-color);
            padding: 30px 10px;
            height: 100vh;
            position: fixed;
            top: 0;
            left: 0;
            display: flex;
            flex-direction: column;
            color: white;
            overflow-y: auto;
        }
        .sidebar a {
            text-decoration: none;
            color: white;
            padding: 10px;
            margin: 10px 0;
            display: block;
            transition: background-color 0.3s;
        }
        .sidebar a:hover {
            background-color: var(--hover-color);
        }
        .main-content {
            margin-left: var(--sidebar-width);
            width: calc(100% - var(--sidebar-width));
            display: flex;
            flex-direction: row;
            padding: 20px;
        }
        .contact-list {
            width: 30%;
            background-color: #f4f4f4;
            border-right: 1px solid var(--border-color);
            height: 100%;
            overflow-y: auto;
            padding: 10px;
        }
        .contact {
            padding: 15px;
            display: flex;
            align-items: center;
            cursor: pointer;
            transition: background-color 0.2s;
        }
        .contact:hover {
            background-color: #e8e8e8;
        }
        .contact img {
            border-radius: 50%;
            width: 40px;
            height: 40px;
            margin-right: 10px;
        }
        .conversation {
            width: 70%;
            padding: 20px;
            overflow-y: auto;
            display: flex;
            flex-direction: column;
            position: relative;
            max-height: 90vh; /* Para asegurar que no se sobrepasen del área visible */
            box-sizing: border-box;
        }
        .message {
            display: flex;
            flex-direction: column;
            align-items: flex-start;
            margin-bottom: 15px;
            padding: 12px;
            border-radius: 8px;
            max-width: 70%;
            word-wrap: break-word;
            font-size: 14px;
            overflow-wrap: break-word; 
            word-break: break-word; /* Fuerza el salto de línea en palabras largas */
            white-space: pre-wrap; 
            
        }
        .message.incoming {
            background-color: #e0f7e0;
            align-self: flex-start;
        }
        .message.outgoing {
            background-color: #cce5ff;
            align-self: flex-end;
        }
        .message-content {
            flex: 1;
            padding: 0 10px;
        }
        .message img {
            max-width: 200px;
            max-height: 200px;
            margin-bottom: 10px;
            border-radius: 5px;
        }
        .message-input {
            display: flex;
            position: fixed;
            bottom: 0;
            right: 0%;
            width: 53.5%;
            padding: 10px;
            background-color: #fff;
            border-top: 1px solid var(--border-color);
            align-items: center;
        }
        .message-input input {
            flex: 1;
            padding: 10px;
            border: 1px solid var(--border-color);
            border-radius: 4px;
            margin-right: 10px;
        }
        .message-input button {
            padding: 10px 20px;
            background-color: var(--primary-color);
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        .message-input button:hover {
            background-color: var(--hover-color);
        }
    </style>
</head>
<body>
<div class="container">
    <div class="sidebar">
        <h2>Banco de Semillas</h2>
        <a href="{{ route('feed.index') }}"><i class="fas fa-home"></i> Inicio</a>
        <a href="{{ route('profile') }}"><i class="fas fa-user"></i> Perfil</a>
        @if (auth()->user()->role->name == 'Agricultor' || auth()->user()->role->name == 'Custodio' || auth()->user()->role->name == 'Casa de Semillas' || auth()->user()->role->name == 'Admin')
        <a href="{{ route('inventory.index') }}"><i class="fas fa-seedling"></i> Inventario</a>
        @endif
        @if (auth()->user()->role->name == 'Agricultor' || auth()->user()->role->name == 'Custodio' || auth()->user()->role->name == 'Casa de Semillas' || auth()->user()->role->name == 'Admin')
        <a href="{{ route('messages.index') }}"><i class="fas fa-envelope"></i> Mensajes</a>
        @endif  
        <a href="{{ route('settings.index') }}"><i class="fas fa-cog"></i> Configuración</a>



        <a href="{{ route('messages.create') }}" class="button"><i class="fas fa-envelope"></i> Redactar Mensaje</a>
    </div>

    <div class="main-content">
        <!-- Lista de Contactos -->
        <div class="contact-list">
            @foreach ($contacts as $contact)
                <div class="contact" onclick="loadConversation({{ $contact->id }})">
                    <img src="{{ $contact->profile_photo_url }}" alt="Foto de {{ $contact->name }}">
                    <span>{{ $contact->name }}</span>
                </div>
            @endforeach
        </div>

        <!-- Conversación -->
        <div class="conversation" id="chat-window">
            <h2>Selecciona un contacto para ver la conversación</h2>
        </div>

        <!-- Entrada de mensaje (barra para escribir mensaje) -->
        <div class="message-input">
            <input type="text" id="message" placeholder="Escribe un mensaje..." />
            <input type="file" id="message-photo" accept="image/*" />
            <button onclick="sendMessage()">Enviar</button>
        </div>
    </div>
</div>

<script>
    let currentContactId = null;

    function loadConversation(contactId) {
        currentContactId = contactId;
        fetch(`/messages/conversation/${contactId}`)
            .then(response => response.json())
            .then(data => {
                const chatWindow = document.getElementById('chat-window');
                chatWindow.innerHTML = ''; 

                data.messages.forEach(message => {
                    const messageDiv = document.createElement('div');
                    messageDiv.classList.add('message');
                    messageDiv.classList.add(message.sender_id === data.auth_user_id ? 'outgoing' : 'incoming');
                    
                    if (message.message) {
                        messageDiv.innerText = message.message;
                    }

                    if (message.photo) {
                        const img = document.createElement('img');
                        img.src = `/storage/${message.photo}`;
                        img.alt = 'Imagen del mensaje';
                        messageDiv.appendChild(img);
                    }

                    chatWindow.appendChild(messageDiv);
                });

                chatWindow.scrollTop = chatWindow.scrollHeight; 
            })
            .catch(error => console.error('Error al cargar la conversación:', error));
    }

    // Función para enviar un mensaje
    function sendMessage() {
        const messageInput = document.getElementById('message');
        const messagePhoto = document.getElementById('message-photo').files[0];
        const message = messageInput.value;

        // Verifica que haya un mensaje o una foto
        if (message.trim() === '' && !messagePhoto) return;

        const formData = new FormData();
        formData.append('receiver_id', currentContactId);
        formData.append('message', message);

        if (messagePhoto) {
            formData.append('photo', messagePhoto);
        }

        fetch('/messages', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Agrega el mensaje al chat
                const chatWindow = document.getElementById('chat-window');
                const messageDiv = document.createElement('div');
                messageDiv.classList.add('message', 'outgoing');

                // Mostrar el texto del mensaje
                if (data.message) {
                    messageDiv.innerText = data.message;
                }

                // Mostrar la imagen si existe
                if (data.photo) {
                    const img = document.createElement('img');
                    img.src = `/storage/${data.photo}`;
                    messageDiv.appendChild(img);
                }

                chatWindow.appendChild(messageDiv);
                chatWindow.scrollTop = chatWindow.scrollHeight;
            } else {
                console.error('Error en el backend:', data.error);
            }
        })
        .catch(error => console.error('Error al enviar el mensaje:', error));

        messageInput.value = ''; // Limpia el campo de mensaje
    }

</script>
</body>
</html>
