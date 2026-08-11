// Widget da Assistente IA Petra para inserção externa

(function () {
    // Adiciona o CSS do Widget dinamicamente
    const style = document.createElement('style');
    style.innerHTML = `
        /* Botão flutuante */
        #petra-chat-button {
            position: fixed;
            bottom: 20px;
            right: 20px;
            width: 60px;
            height: 60px;
            background-color: #004AAD;
            color: white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 4px 10px rgba(0,0,0,0.3);
            cursor: pointer;
            z-index: 999999;
            transition: transform 0.3s;
            font-size: 28px;
        }
        #petra-chat-button:hover {
            transform: scale(1.1);
            background-color: #0073E6;
        }

        /* Container do chat */
        #petra-chat-widget {
            position: fixed;
            bottom: 90px;
            right: 20px;
            width: 350px;
            height: 500px;
            background-color: #F4F4F4;
            border-radius: 12px;
            box-shadow: 0 8px 16px rgba(0,0,0,0.2);
            display: flex;
            flex-direction: column;
            overflow: hidden;
            z-index: 999998;
            transition: all 0.3s ease;
            transform: translateY(20px);
            opacity: 0;
            pointer-events: none;
            font-family: "Inter", Arial, sans-serif;
            border: 1px solid #ddd;
        }

        #petra-chat-widget.open {
            transform: translateY(0);
            opacity: 1;
            pointer-events: auto;
        }

        /* Cabeçalho */
        #petra-chat-header {
            background-color: #004AAD;
            color: white;
            padding: 15px;
            font-size: 16px;
            font-weight: 600;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        #petra-chat-close {
            cursor: pointer;
            font-size: 20px;
            background: none;
            border: none;
            color: white;
        }

        /* Área de Mensagens */
        #petra-chat-body {
            flex: 1;
            padding: 15px;
            overflow-y: auto;
            display: flex;
            flex-direction: column;
            gap: 10px;
            background-color: white;
        }

        .petra-msg {
            max-width: 85%;
            padding: 10px 14px;
            border-radius: 12px;
            line-height: 1.4;
            font-size: 14px;
            word-wrap: break-word;
        }
        .petra-msg.bot {
            background-color: #EAEAEA;
            color: #1E1E1E;
            align-self: flex-start;
            border-top-left-radius: 2px;
        }
        .petra-msg.user {
            background-color: #0073E6;
            color: white;
            align-self: flex-end;
            border-top-right-radius: 2px;
        }

        /* Input */
        #petra-chat-footer {
            padding: 10px;
            background-color: #f9f9f9;
            border-top: 1px solid #ddd;
            display: flex;
            align-items: center;
        }
        #petra-chat-input {
            flex: 1;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 20px;
            outline: none;
            font-size: 14px;
        }
        #petra-chat-send {
            background-color: #004AAD;
            color: white;
            border: none;
            border-radius: 50%;
            width: 36px;
            height: 36px;
            margin-left: 8px;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        #petra-chat-send:active {
            transform: scale(0.95);
        }

        /* Responsive para mobile */
        @media (max-width: 450px) {
            #petra-chat-widget {
                width: 100%;
                height: 100%;
                bottom: 0;
                right: 0;
                border-radius: 0;
            }
        }
    `;
    document.head.appendChild(style);

    // Estrutura HTML do Widget
    const widgetHTML = `
        <div id="petra-chat-widget">
            <div id="petra-chat-header">
                <span>🤖 Petra - Trade Expansion</span>
                <button id="petra-chat-close">✖</button>
            </div>
            <div id="petra-chat-body">
                <div class="petra-msg bot">
                    Olá! 👋 Sou a Petra, assistente da <strong>Trade Expansion</strong>.<br><br>
                    Posso te ajudar a entender mais sobre rochas ornamentais, cotações ou nosso processo de exportação.
                </div>
            </div>
            <div id="petra-chat-footer">
                <input type="text" id="petra-chat-input" placeholder="Digite sua mensagem..." autocomplete="off">
                <button id="petra-chat-send">➤</button>
            </div>
        </div>
        <div id="petra-chat-button">
            💬
        </div>
    `;

    // Anexa o widget ao final do body
    const widgetContainer = document.createElement('div');
    widgetContainer.innerHTML = widgetHTML;
    document.body.appendChild(widgetContainer);

    // Lógica do JS
    const button = document.getElementById('petra-chat-button');
    const widget = document.getElementById('petra-chat-widget');
    const closeBtn = document.getElementById('petra-chat-close');
    const sendBtn = document.getElementById('petra-chat-send');
    const input = document.getElementById('petra-chat-input');
    const body = document.getElementById('petra-chat-body');

    // Substitua pela URL da sua API hospedada no Render.
    // Exemplo: const API_URL = "https://trade-expansion-ai.onrender.com/chat";
    const API_URL = "https://petra-ai.onrender.com/chat"; // Patter atual local. Alterar depois de hospedar!

    button.addEventListener('click', () => {
        widget.classList.toggle('open');
        if (widget.classList.contains('open')) {
            input.focus();
        }
    });

    closeBtn.addEventListener('click', () => {
        widget.classList.remove('open');
    });

    function addMessage(text, sender) {
        const msgDiv = document.createElement('div');
        msgDiv.className = `petra-msg ${sender}`;

        // Transformando markdown base / quebras de linha (<br>)
        msgDiv.innerHTML = text.replace(/\n/g, "<br>").replace(/\*\*(.*?)\*\*/g, "<strong>$1</strong>");

        body.appendChild(msgDiv);
        body.scrollTop = body.scrollHeight;
    }

    async function handleSend() {
        const text = input.value.trim();
        if (!text) return;

        addMessage(text, 'user');
        input.value = '';
        input.disabled = true;
        sendBtn.disabled = true;

        try {
            const response = await fetch(API_URL, {
                method: "POST",
                headers: { "Content-Type": "application/json" },
                body: JSON.stringify({ message: text })
            });

            if (!response.ok) throw new Error("Erro na API");
            const data = await response.json();

            addMessage(data.answer, 'bot');
        } catch (error) {
            console.error("Erro no Chatbot:", error);
            addMessage("⚠️ Desculpe, estou com problemas de conexão. Tente novamente mais tarde.", 'bot');
        } finally {
            input.disabled = false;
            sendBtn.disabled = false;
            input.focus();
        }
    }

    sendBtn.addEventListener('click', handleSend);
    input.addEventListener('keypress', (e) => {
        if (e.key === 'Enter') handleSend();
    });

})();
