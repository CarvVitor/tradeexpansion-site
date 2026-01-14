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
        <li><a href="<?php echo is_front_page() ? '#sobre' : esc_url( home_url('/#sobre') ); ?>" class="hover:text-accent transition">Sobre</a></li>
        <li><a href="<?php echo is_front_page() ? '#servicos' : esc_url( home_url('/#servicos') ); ?>" class="hover:text-accent transition">Serviços</a></li>
        <li><a href="<?php echo is_front_page() ? '#faq' : esc_url( home_url('/#faq') ); ?>" class="hover:text-accent transition">Perguntas Frequentes</a></li>
        <li><a href="<?php echo esc_url( home_url('/contato') ); ?>" class="hover:text-accent transition">Contato</a></li>
      </ul>
    </div>

    <!-- Coluna 3 – Contato & redes sociais -->
    <div>
      <h4 class="text-lg font-semibold mb-3 uppercase tracking-wide">Contato</h4>
      <p class="leading-relaxed mb-4">
        <a href="mailto:vitor@tradeexpansion.com.br"  class="hover:text-accent transition">vitor@tradeexpansion.com.br</a><br>
        <a href="mailto:valeria@tradeexpansion.com.br"  class="hover:text-accent transition">valeria@tradeexpansion.com.br</a><br>
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
<a href="<?php echo esc_url( home_url('/contato') ); ?>" class="floating-cta" title="Solicitar Cotação">
    📧
</a>

<script>
  (function () {
    const header = document.getElementById('teHeader');
    if (header) {
      const toggleHeader = () => {
        header.classList.toggle('is-scrolled', window.scrollY > 24);
      };
      toggleHeader();
      window.addEventListener('scroll', toggleHeader, { passive: true });
    }

    // Parallax sutil (desktop / respeita reduced motion)
    const prefersReduced = window.matchMedia && window.matchMedia('(prefers-reduced-motion: reduce)').matches;
    const isCoarse = window.matchMedia && window.matchMedia('(pointer: coarse)').matches;
    if (prefersReduced || isCoarse) return;

    const heroVideo = document.querySelector('.hero-video');
    const breakVideo = document.querySelector('.te-break-video');
    if (!heroVideo && !breakVideo) return;

    let ticking = false;
    const onScroll = () => {
      if (ticking) return;
      ticking = true;
      window.requestAnimationFrame(() => {
        const y = window.scrollY || 0;
        const p1 = Math.min(28, y * 0.08);
        const p2 = Math.min(20, y * 0.05);
        if (heroVideo) heroVideo.style.transform = `translate3d(0, ${p1}px, 0) scale(1.03)`;
        if (breakVideo) breakVideo.style.transform = `translate3d(0, ${p2}px, 0) scale(1.02)`;
        ticking = false;
      });
    };
    window.addEventListener('scroll', onScroll, { passive: true });
  })();
</script>

<?php wp_footer(); ?>
</body>
</html>