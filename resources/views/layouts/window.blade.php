{{-- resources/views/chat/window.blade.php --}}
<style scoped>
    .app-shell {
        display: flex;
        flex-direction: column;
        height: 100vh;
        width: 100%;
        margin-left: 300px;
        transition: margin-left 0.3s ease;
    }


    /* 🌟 Style du contenu généré par l'assistant */
    .message.assistant .bubble {
        line-height: 1.6;
        font-size: 0.95rem;
        color: #2c2c2c;
    }

    /* Paragraphes */
    .message.assistant .bubble p {
        margin-bottom: 0.8em;
    }

    /* Titres */
    .message.assistant .bubble h1,
    .message.assistant .bubble h2,
    .message.assistant .bubble h3 {
        color: var(--primary-color);
        /* Violet principal */
        font-weight: 700;
        margin: 1em 0 0.5em;
        line-height: 1.3;
    }

    .message.assistant .bubble h1 {
        font-size: 1.4rem;
        border-bottom: 2px solid #e0c6f5;
        padding-bottom: 0.3em;
    }

    .message.assistant .bubble h2 {
        font-size: 1.25rem;
    }

    .message.assistant .bubble h3 {
        font-size: 1.1rem;
    }

    /* Listes */
    .message.assistant .bubble ul,
    .message.assistant .bubble ol {
        padding-left: 1.2em;
        margin-bottom: 0.8em;
    }

    .message.assistant .bubble li {
        margin-bottom: 0.4em;
    }

    /* Tableaux */
    .message.assistant .bubble table {
        border-collapse: collapse;
        width: 100%;
        margin: 1em 0;
        font-size: 0.9rem;
        /* background-color: #faf8fc; */
        border-radius: 8px;
        overflow: hidden;
    }

    .message.assistant .bubble th {
        /* background-color: #f3e6fa; */
        color: var(--primary-color);
        font-weight: 600;
        text-align: left;
    }

    .message.assistant .bubble th,
    .message.assistant .bubble td {
        /* border: 1px solid #d6bce8; */
        padding: 8px 10px;
    }

    /* Séparateurs (<hr>) */
    .message.assistant .bubble hr {
        border: none;
        border-top: 1px solid #d8c2f0;
        margin: 1.2em 0;
    }

    /* Liens */
    .message.assistant .bubble a {
        color: #6a0dad;
        text-decoration: underline;
    }

    .message.assistant .bubble a:hover {
        color: #4a0072;
    }


    /* Adaptation pour le menu rail (mode icônes) sur desktop */
    @media (min-width: 769px) {
        .navigation-drawer.rail~.main-content .app-shell {
            margin-left: 72px;
        }
    }

    .app-bar {
        height: 80px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 0 20px;
        background-color: var(--surface-color);
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        position: fixed;
        top: 0;
        left: 300px;
        right: 0;
        z-index: 998;
        transition: left 0.3s ease;
    }

    .app-bar-title {
        display: flex;
        align-items: center;
        flex: 1;
    }

    .app-bar-actions {
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .icon-btn {
        background: none;
        border: none;
        cursor: pointer;
        padding: 8px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: background-color 0.2s;
    }

    .icon-btn:hover {
        background-color: rgba(0, 0, 0, 0.04);
    }

    .icon-btn i {
        font-size: 24px;
    }

    .ml-12 {
        margin-left: 12px;
    }

    .menu-container {
        position: relative;
    }

    .dropdown-menu {
        position: absolute;
        top: 100%;
        right: 0;
        margin-top: 8px;
        background: white;
        border-radius: 8px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
        min-width: 180px;
        display: none;
        z-index: 1000;
    }

    .dropdown-menu.show {
        display: block;
    }

    .menu-item {
        display: block;
        padding: 12px 16px;
        text-decoration: none;
        color: inherit;
        transition: background-color 0.2s;
        border: none;
        width: 100%;
        text-align: left;
        background: none;
        cursor: pointer;
    }

    .menu-item:hover {
        background-color: rgba(0, 0, 0, 0.04);
    }

    .menu-item:first-child {
        border-radius: 8px 8px 0 0;
    }

    .menu-item:last-child {
        border-radius: 0 0 8px 8px;
    }

    .menu-item-btn {
        font-size: inherit;
        font-family: inherit;
    }

    .chat-area {
        flex: 1;
        display: flex;
        flex-direction: column;
        background-color: var(--background-color);
        color: var(--text-color, #000000);
        margin-top: 80px;
        overflow: hidden;
        margin-right: 300px;
        overflow: hidden;
        max-width: 4000px;
    }

    .chat-wrapper {
        flex: 1;
        display: flex;
        flex-direction: column;
        max-width: 1200px;
        width: 100%;
        margin: 0 auto;
        background-color: var(--surface-color);
        border-left: 1px solid #e0e0e0;
        border-right: 1px solid #e0e0e0;
        box-shadow: 0 0 20px rgba(0, 0, 0, 0.05);
        overflow-y: auto;
    }

    .message-container {
        flex: 1;
        overflow-y: auto;
        padding: 20px;
        background-color: #fafafa;
    }

    .chat-input {
        background-color: #ffffff;
        border-top: 1px solid #e0e0e0;
        padding: 16px;
        display: flex;
        flex-direction: column;
        gap: 12px;
    }

    .empty-state {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        height: 100%;
        opacity: 0.5;
        text-align: center;
    }

    .empty-state i {
        font-size: 64px;
        margin-bottom: 16px;
    }

    .empty-state p {
        margin: 4px 0;
    }

    .text-muted {
        font-size: 14px;
        opacity: 0.7;
    }

    .header {
        display: flex;
        align-items: center;
        gap: 16px;
        padding-left: 10px;
        padding-top: 10px;
        border-bottom: 1px solid #eee;
    }

    .header-logo .logo-img {
        width: 70px;
        height: 70px;
        border-radius: 50%;
        object-fit: cover;
        border: 3px solid #eaeaecf5;
        box-shadow: 0 4px 16px rgba(0, 0, 0, 0.15);
    }

    .header-text {
        display: flex;
        flex-direction: column;
        gap: 4px;
    }

    .header-text h3 {
        margin: 0;
        font-size: 1.3rem;
        font-weight: 600;
    }

    .header-text p {
        margin: 0;
        font-size: 0.9rem;
        opacity: 0.7;
    }

    .loader {
        display: flex;
        gap: 4px;
    }

    .loader span {
        width: 6px;
        height: 6px;
        background: #555;
        border-radius: 50%;
        display: inline-block;
        animation: bounce 1.2s infinite ease-in-out;
    }

    .loader span:nth-child(1) {
        animation-delay: 0s;
    }

    .loader span:nth-child(2) {
        animation-delay: 0.2s;
    }

    .loader span:nth-child(3) {
        animation-delay: 0.4s;
    }

    @keyframes bounce {

        0%,
        80%,
        100% {
            transform: scale(0);
        }

        40% {
            transform: scale(1);
        }
    }

    .message {
        display: flex;
        margin: 8px 0;
        opacity: 0;
        transform: translateY(70px);
        animation: fadeUp 0.8s ease-out forwards;
    }

    .message.user {
        justify-content: flex-end;
    }

    .message.assistant,
    .message.system {
        justify-content: flex-start;
    }

    .avatar {
        width: 32px;
        height: 32px;
        border-radius: 50%;
        object-fit: cover;
        margin: 0 8px;
        border: 1px solid rgba(0, 0, 0, 0.08);
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.06);
    }

    .bubble {
        max-width: 70%;
        padding: 12px;
        border-radius: 12px;
        border: 1px solid #cccccc;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
    }

    .meta {
        margin-top: 6px;
        font-size: 11px;
        color: #666666;
    }

    .meta.right {
        text-align: right;
    }

    @keyframes fadeUp {
        0% {
            opacity: 0;
            transform: translateY(70px);
        }

        100% {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .message.user .bubble {
        background: var(--primary-light);
        color: #ffffff;
        border-color: var(--primary-light);
    }

    .message.user .meta {
        color: rgba(255, 255, 255, 0.8);
    }

    .message.assistant .bubble {
        background: var(--background-color);
        color: #000000;
        border-color: #cccccc;
    }

    .message.system .bubble {
        background: var(--background-color);
        color: #666666;
        border-color: #e0e0e0;
        font-style: italic;
    }

    .suggestions-row {
        display: flex;
        gap: 9px;
        flex-wrap: wrap;
        align-items: center;
    }

    .suggestion-btn {
        padding: 6px 12px;
        border: 1px solid #cccccc;
        border-radius: 9999px;
        color: #000000;
        background: var(--primary-lighter);
        text-transform: none;
        cursor: pointer;
        font-size: 14px;
        transition: background-color 0.3s;
    }

    .suggestion-btn:hover {
        background-color: var(--primary-over);
    }

    #chatTextarea {
        flex: 1;
        min-height: 58px;
        resize: vertical;
        background-color: #ffffff;
        color: #000000;
        border: 1px solid #e0e0e0;
        border-radius: 10px;
        padding: 8px;
        font-family: inherit;
        font-size: 14px;
    }

    .input-row {
        display: flex;
        gap: 8px;
        align-items: flex-end;
    }

    .send-button {
        width: 60px;
        height: 60px;
        border-radius: 50%;
        background-color: var(--primary-color);
        color: #ffffff;
        border: none;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        font-size: 24px;
        transition: background-color 0.3s;
        flex-shrink: 0;
    }

    .send-button:hover:not(:disabled) {
        background-color: var(--primary-color);
    }

    .send-button:disabled {
        opacity: 0.5;
        cursor: not-allowed;
    }

    .fade-slide-enter {
        animation: fadeSlide 0.8s ease-out;
    }

    @keyframes fadeSlide {
        from {
            opacity: 0;
            transform: translateY(70px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    /* Responsive Mobile (≤ 768px) */
    @media (max-width: 768px) {
        .app-shell {
            margin-left: 0;
            width: 100%;
        }

        .app-bar {
            left: 0;
            right: 0;
            padding: 0 12px;
            height: 70px;
        }

        .chat-area {
            margin-top: 70px;
            margin-right: 0;
        }


        .chat-wrapper {
            flex: 1;
            display: flex;
            flex-direction: column;
            max-width: 1200px;
            width: 100%;
            padding: 12px;
            margin: 0 auto;
            background-color: var(--background-color);
            border-left: 1px solid #e0e0e0;
            border-right: 1px solid #e0e0e0;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.05);
            overflow-y: auto;
            /* ✅ permet le scroll vertical */
            overflow-x: hidden;
        }


        .header {
            padding-left: 8px;
            padding-top: 8px;
            gap: 12px;
        }

        .header-logo .logo-img {
            width: 50px;
            height: 50px;
            border-width: 2px;
        }

        .d-none-xs {
            display: none !important;
        }

        .ml-2-xs {
            margin-left: 8px !important;
        }

        .ml-12 {
            margin-left: 8px;
        }

        .header-text h3 {
            font-size: 1.1rem;
        }

        .header-text p {
            font-size: 0.8rem;
        }

        .bubble {
            max-width: 85%;
            padding: 10px;
        }

        .avatar {
            width: 28px;
            height: 28px;
            margin: 0 6px;
        }

        .chat-input {
            padding: 12px;
            gap: 10px;
        }

        .suggestions-row {
            gap: 6px;
        }

        .suggestion-btn {
            padding: 5px 10px;
            font-size: 13px;
        }

        #chatTextarea {
            min-height: 50px;
            font-size: 13px;
            padding: 10px;
        }

        .send-button {
            width: 50px;
            height: 50px;
            font-size: 20px;
        }

        .icon-btn {
            padding: 6px;
        }

        .icon-btn i {
            font-size: 20px;
        }

        .empty-state i {
            font-size: 48px;
        }

        .empty-state p {
            font-size: 14px;
        }

        .meta {
            font-size: 10px;
        }
    }

    /* Tablette (769px - 1024px) */
    @media (min-width: 769px) and (max-width: 1024px) {
        .app-shell {
            margin-left: 300px;
        }

        .app-bar {
            left: 300px;
        }

        .chat-wrapper {
            max-width: 900px;
        }

        .bubble {
            max-width: 75%;
        }
    }

    /* Desktop large (> 1024px) */
    @media (min-width: 1025px) {
        .app-shell {
            margin-left: 300px;
        }

        .app-bar {
            left: 300px;
        }
    }

    /* Ajustement dynamique pour le menu en mode rail sur desktop */
    @media (min-width: 769px) {
        body:has(.navigation-drawer.rail) .app-shell {
            margin-left: 72px;
        }

        body:has(.navigation-drawer.rail) .app-bar {
            left: 52px;
        }
    }
</style>

<div class="app-shell">
    <!-- App Bar / Header -->
    <header class="app-bar">
        <div class="app-bar-title">
            <div class="header fade-slide-enter">
                <div class="header-logo">
                    <img src="{{ asset('logo.jpg') }}" alt="Logo" class="logo-img" />
                </div>
                <div class="header-text d-none-xs">
                    <h3>Legal Chat IA</h3>
                    <p>Assistante juridique intelligente</p>
                </div>
            </div>
        </div>

        <div class="app-bar-actions">
            <button class="icon-btn ml-12 ml-2-xs">
                <i class="mdi mdi-magnify"></i>
            </button>

            <div class="menu-container ml-12 ml-2-xs">
                <button class="icon-btn" onclick="toggleMenu()">
                    <i class="mdi mdi-dots-vertical"></i>
                </button>

                <div class="dropdown-menu" id="dropdownMenu">
                    <a href="{{ route('profil') }}" class="menu-item">Profil</a>
                    <a href="{{ route('about') }}" class="menu-item">Paramètres</a>
                    <form action="{{ route('logout') }}" method="POST" style="margin: 0;">
                        @csrf
                        <button type="submit" class="menu-item menu-item-btn">Déconnexion</button>
                    </form>
                </div>
            </div>
        </div>
    </header>

    <!-- Main Chat Area -->
    <main class="chat-area">
        <div class="chat-wrapper">
            <input type="hidden" id="activeConversationId" value="{{ $activeConversationId }}">

            <!-- Messages existants depuis le contrôleur -->
            @forelse($messages ?? [] as $msg)
                @if ($msg['role'] === 'user')
                    <div class="message user">
                        <div class="bubble">
                            <div>{!! $msg['message'] !!}</div>
                            <div class="meta right">{{ \Carbon\Carbon::parse($msg['created_at'])->format('H:i') }}
                            </div>
                        </div>
                        <img class="avatar" src="{{ asset($user->avatar) }}" alt="Utilisateur" />
                    </div>
                @elseif($msg['role'] === 'assistant')
                    <div class="message assistant">
                        <img class="avatar" src="{{ asset('logo.jpg') }}" alt="Assistant" />
                        <div class="bubble">
                            <div>{!! $msg['message'] !!}</div>
                            <div class="meta">{{ \Carbon\Carbon::parse($msg['created_at'])->format('H:i') }}</div>
                        </div>
                    </div>
                @endif

            @empty
                <div class="empty-state">
                    <i class="mdi mdi-message-text-outline"></i>
                    <p>Aucun message pour le moment</p>
                    <p class="text-muted">Posez votre première question juridique</p>
                </div>
            @endforelse
        </div>

        <div class="chat-input">


            @if (count($messages ?? []) < 0)
                <div class="suggestions-row">
                    @foreach ($suggestions ?? [] as $suggestion)
                        <button class="suggestion-btn" onclick="pickSuggestion(this.getAttribute('data-question'))"
                            data-question="{{ $suggestion['text'] }}" title="{{ $suggestion['text'] }}">
                            {{ $suggestion['short'] }}
                        </button>
                    @endforeach
                </div>
            @endif

            <div class="input-row">
                <textarea id="chatTextarea" placeholder="Écris ta question juridique..." onkeydown="handleEnter(event)"></textarea>
                <button id="sendBtn" class="send-button" onclick="sendMessage()" disabled>
                    <i class="mdi mdi-send"></i>
                </button>
            </div>
        </div>
</div>
</main>
</div>

<script>
    // Toggle dropdown menu
    function toggleMenu() {
        const menu = document.getElementById('dropdownMenu');
        menu.classList.toggle('show');
    }

    // Close menu when clicking outside
    document.addEventListener('click', function(event) {
        const menuContainer = document.querySelector('.menu-container');
        const menu = document.getElementById('dropdownMenu');

        if (menuContainer && !menuContainer.contains(event.target)) {
            menu.classList.remove('show');
        }
    });

    // Scroll to bottom function
    function scrollToBottom() {
        const container = document.querySelector('.chat-wrapper');
        if (container) {
            container.scrollTop = container.scrollHeight;
        }
    }

    // Pick suggestion
    function pickSuggestion(question) {
        const textarea = document.getElementById('chatTextarea');
        textarea.value = question;
        updateSendButton();
        textarea.focus();
    }

    // Handle Enter key
    function handleEnter(event) {
        if (event.key === 'Enter' && !event.shiftKey) {
            event.preventDefault();
            sendMessage();
        }
    }

    // Update send button state
    function updateSendButton() {
        const textarea = document.getElementById('chatTextarea');
        const sendBtn = document.getElementById('sendBtn');
        sendBtn.disabled = !textarea.value.trim();
    }

    // Initialize on page load
    document.addEventListener('DOMContentLoaded', function() {
        const textarea = document.getElementById('chatTextarea');
        textarea.addEventListener('input', updateSendButton);

        // Scroll to bottom on page load
        scrollToBottom();

        // Scroll after images are loaded
        setTimeout(() => {
            scrollToBottom();
        }, 100);
    });

    // Also scroll when page is fully loaded (including images)
    window.addEventListener('load', function() {
        scrollToBottom();
    });

    // Format time
    function formatTime(timestamp) {
        const d = new Date(timestamp);
        const hours = d.getHours().toString().padStart(2, '0');
        const minutes = d.getMinutes().toString().padStart(2, '0');
        return `${hours}:${minutes}`;
    }

    // Create loading message
    function createLoadingMessage() {
        const messageDiv = document.createElement('div');
        messageDiv.className = 'message assistant';
        messageDiv.innerHTML = `
            <img class="avatar" src="{{ asset('logo.jpg') }}" alt="Assistant" />
            <div class="bubble">
                <div class="loader">
                    <span></span><span></span><span></span>
                </div>
                <div class="meta">${formatTime(Date.now())}</div>
            </div>
        `;
        return messageDiv;
    }

    // Create user message
    function createUserMessage(content, timestamp = Date.now()) {
        const messageDiv = document.createElement('div');
        messageDiv.className = 'message user';
        const escapedContent = content.replace(/&/g, "&amp;")
            .replace(/</g, "&lt;")
            .replace(/>/g, "&gt;")
            .replace(/\n/g, "<br>");

        messageDiv.innerHTML = `
            <div class="bubble">
                <div>${escapedContent}</div>
                <div class="meta right">${formatTime(timestamp)}</div>
            </div>
            <img class="avatar" src="{{ $user->avatar }}" alt="Utilisateur" />
        `;
        return messageDiv;
    }

    // Create assistant message
    function createAssistantMessage(content, timestamp = Date.now()) {
        const messageDiv = document.createElement('div');
        messageDiv.className = 'message assistant';
        const escapedContent = content.replace(/&/g, "&amp;")
            .replace(/</g, "&lt;")
            .replace(/>/g, "&gt;")
            .replace(/\n/g, "<br>");

        messageDiv.innerHTML = `
            <img class="avatar" src="{{ asset('logo.jpg') }}" alt="Assistant" />
            <div class="bubble">
                <div>${escapedContent}</div>
                <div class="meta">${formatTime(timestamp)}</div>
            </div>
        `;
        return messageDiv;
    }

    // Get conversation ID from the page
    function getConversationId() {
        const container = document.querySelector('.chat-wrapper');
        return container?.dataset.conversationId || null;
    }

    // Send message
    async function sendMessage() {
        const textarea = document.getElementById('chatTextarea');
        const message = textarea.value.trim();
        const conversationIdInput = document.getElementById('activeConversationId');
        const conversationId = conversationIdInput.value;

        console.log('Sending message to conversation ID:', conversationId);

        if (!message) return;


        const container = document.querySelector('.chat-wrapper');

        // Remove empty state if present
        const emptyState = container.querySelector('.empty-state');
        if (emptyState) {
            emptyState.remove();
        }

        // Add user message
        const userMessage = createUserMessage(message);
        container.appendChild(userMessage);

        // Reset textarea
        textarea.value = '';
        updateSendButton();

        // Scroll to bottom after user message
        scrollToBottom();

        // Add loading message
        const loadingElement = createLoadingMessage();
        container.appendChild(loadingElement);

        // Scroll to bottom after loading message
        scrollToBottom();

        // Prepare request body
        const requestBody = {
            message: message
        };

        // Add conversation_id if it exists
        if (conversationId) {
            requestBody.conversation_id = conversationId;
        }

        // API call
        try {
            let response = await fetch('{{ route('chat.send') }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json'
                },
                body: JSON.stringify(requestBody),
                credentials: 'include'
            });

            let data;
            const text = await response.text(); // lire une seule fois

            try {
                data = JSON.parse(text); // tenter d’interpréter comme JSON
            } catch (err) {
                console.error('Réponse non JSON :', text); // afficher le HTML complet
                throw err;
            }


            // Remove loading
            loadingElement.remove();

            if (data.success) {
                // Add assistant response
                const assistantMessage = createAssistantMessage(data.response, data.timestamp);
                assistantMessage.innerHTML = data.response;
                container.appendChild(assistantMessage);
            } else {
                // Add error message
                const errorMessage = document.createElement('div');
                errorMessage.classList.add('message', 'error');
                errorMessage.textContent = 'Erreur: ' + (data.message || 'Une erreur est survenue');
                container.appendChild(errorMessage);
            }

            // Scroll to bottom after assistant message
            scrollToBottom();

        } catch (error) {
            console.error(error);
            loadingElement.remove();

            const errorMessage = createAssistantMessage('Erreur lors de l\'envoi du message. Veuillez réessayer.');
            container.appendChild(errorMessage);

            // Scroll to bottom after error message
            scrollToBottom();
        }
    }
</script>
