<footer class="bg-secondary text-custom1 py-12 px-6 md:px-20">
  <div class="max-w-6xl mx-auto grid md:grid-cols-3 gap-8">

    <!-- Coluna 1 – Sobre a empresa -->
    <div>
      <h4 class="text-lg font-semibold mb-3 uppercase tracking-wide">Trade Expansion</h4>
      <p class="text-custom1/80 leading-relaxed">
        Conectamos produtores brasileiros a compradores internacionais com excelência operacional e visão global.
        Você exporta com confiança. Nós expandimos suas fronteiras.
      </p>
    </div>

    <!-- Coluna 2 – Navegação rápida -->
    <div>
      <h4 class="text-lg font-semibold mb-3 uppercase tracking-wide">Links úteis</h4>
      <ul class="space-y-2">
        <li><a href="#sobre" class="hover:text-accent transition">Sobre</a></li>
        <li><a href="#servicos" class="hover:text-accent transition">Serviços</a></li>
        <li><a href="#faq" class="hover:text-accent transition">Perguntas Frequentes</a></li>
        <li><a href="#contato" class="hover:text-accent transition">Contato</a></li>
      </ul>
    </div>

    <!-- Coluna 3 – Contato & redes sociais -->
    <div>
      <h4 class="text-lg font-semibold mb-3 uppercase tracking-wide">Contato</h4>
      <p class="leading-relaxed mb-4">
        <a href="mailto:vitor@tradeexpansion.com.br"
          class="hover:text-accent transition">vitor@tradeexpansion.com.br</a><br>
        <a href="mailto:valeria@tradeexpansion.com.br"
          class="hover:text-accent transition">valeria@tradeexpansion.com.br</a><br>
        <a href="tel:+5527992284517" class="hover:text-accent transition">+55 27 99228-4517</a>
      </p>
      <div class="flex space-x-4">
        <a href="https://www.linkedin.com/company/tradeexpansion" class="hover:text-accent transition">
          <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24"><!-- ícone LinkedIn --></svg>
        </a>
        <a href="https://www.instagram.com/tradeexpansion" class="hover:text-accent transition">
          <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24"><!-- ícone Instagram --></svg>
        </a>
      </div>
    </div>

  </div>

  <div class="mt-12 border-t border-custom1/20 pt-6 text-center text-sm text-custom1/60">
    © <?php echo date('Y'); ?> Trade Expansion LTDA – Todos os direitos reservados.
  </div>
</footer>

<!-- FLOATING CTA -->
<a href="/contact" class="floating-cta" title="Solicitar Cotação">
  📧
</a>

<!-- AI Chat Widget -->
<div id="te-chat-launcher" title="Falar com Petra (Assistente Virtual)">
  <svg viewBox="0 0 24 24">
    <path d="M20 2H4c-1.1 0-2 .9-2 2v18l4-4h14c1.1 0 2-.9 2-2V4c0-1.1-.9-2-2-2zm0 14H6l-2 2V4h16v12z" />
    <path d="M11 9h2v2h-2zm-3 0h2v2H8zm6 0h2v2h-2z" fill="currentColor" />
  </svg>
</div>

<div id="te-chat-window">
  <div id="te-chat-header">
    <div class="title-area">
      <h3>Petra</h3>
      <span>Trade Expansion Assistant</span>
    </div>
    <button id="te-chat-close">
      <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
        <path d="M6 18L18 6M6 6l12 12" stroke-linecap="round" stroke-linejoin="round" />
      </svg>
    </button>
  </div>

  <div id="te-chat-messages">
    <!-- Welcome Message -->
    <div class="chat-message bot">
      Ol&aacute;! 👋 Sou a <strong>Petra</strong>, assistente da Trade Expansion.<br><br>
      Como posso te ajudar hoje com informa&ccedil;&otilde;es sobre exporta&ccedil;&atilde;o de rochas ou nossos
      servi&ccedil;os?
    </div>
  </div>

  <div id="te-chat-input-area">
    <input type="text" id="te-chat-input" placeholder="Digite sua mensagem...">
    <button id="te-chat-send" disabled>
      <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
        <path d="M22 2L11 13M22 2l-7 20-4-9-9-4 20-7z" stroke-linecap="round" stroke-linejoin="round" />
      </svg>
    </button>
  </div>
</div>

<?php wp_footer(); ?>
</body>

</html>