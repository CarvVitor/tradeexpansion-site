<?php
/**
 * Login View Template
 * Path: client-portal/views/login.php
 * High-end cinematic luxury design
 */

get_header();

$status_code = isset($_GET['portal_status']) ? sanitize_text_field(wp_unslash($_GET['portal_status'])) : '';
$status_message = $status_code ? te_client_portal_get_status_message($status_code) : null;
$current_user = is_user_logged_in() ? wp_get_current_user() : null;
$already_logged = $current_user && te_client_portal_user_is_allowed($current_user);
?>

<style>
  :root {
    --primary-gold: #D6A354;
    --deep-green: #0B1D1B;
    --text-bright: #F1F1D9;
    --glass-bg: rgba(11, 29, 27, 0.6);
    --glass-border: rgba(255, 255, 255, 0.05);
    --sans-font: 'Inter', sans-serif;
  }

  .login-cinematic {
    min-height: 100vh;
    background-color: var(--deep-green);
    background-image:
      radial-gradient(circle at 15% 15%, rgba(214, 163, 84, 0.08) 0%, transparent 50%),
      radial-gradient(circle at 85% 85%, rgba(93, 39, 19, 0.1) 0%, transparent 50%);
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 40px 20px;
    font-family: 'Vollkorn', serif;
  }

  .login-glass-container {
    width: 100%;
    max-width: 1100px;
    background: var(--glass-bg);
    backdrop-filter: blur(40px);
    -webkit-backdrop-filter: blur(40px);
    border: 1px solid var(--glass-border);
    border-radius: 40px;
    display: grid;
    grid-template-columns: 1.1fr 1fr;
    overflow: hidden;
    box-shadow: 0 60px 120px -20px rgba(0, 0, 0, 0.7);
  }

  @media (max-width: 1000px) {
    .login-glass-container {
      grid-template-columns: 1fr;
      max-width: 500px;
    }

    .branding-side {
      display: none;
    }
  }

  .branding-side {
    padding: 100px;
    display: flex;
    flex-direction: column;
    justify-content: space-between;
    background: linear-gradient(rgba(11, 29, 27, 0.5), rgba(11, 29, 27, 0.5)),
      url('https://tradeexpansion.com.br/wp-content/themes/tradeexpansion-site-main/assets/images/hero-stone.jpg');
    background-size: cover;
    background-position: center;
    position: relative;
  }

  .branding-side::after {
    content: "";
    position: absolute;
    inset: 0;
    background: linear-gradient(to right, transparent, var(--deep-green));
  }

  .branding-content {
    position: relative;
    z-index: 2;
  }

  .editorial-tag {
    font-size: 10px;
    text-transform: uppercase;
    letter-spacing: 0.4em;
    color: var(--primary-gold);
    font-weight: 900;
    margin-bottom: 30px;
    display: block;
  }

  .form-side {
    padding: 100px 80px;
    display: flex;
    flex-direction: column;
    justify-content: center;
  }

  .luxury-label {
    font-family: var(--sans-font);
    font-size: 10px;
    text-transform: uppercase;
    letter-spacing: 0.3em;
    color: rgba(241, 241, 217, 0.3);
    font-weight: 700;
    margin-bottom: 8px;
    display: block;
  }

  .minimal-input {
    background: transparent;
    border: none;
    border-bottom: 1px solid rgba(214, 163, 84, 0.2);
    padding: 18px 0;
    width: 100%;
    color: var(--text-bright);
    font-family: 'Vollkorn', serif;
    font-size: 20px;
    transition: all 0.4s cubic-bezier(0.165, 0.84, 0.44, 1);
  }

  .minimal-input:focus {
    outline: none;
    border-bottom-color: var(--primary-gold);
    box-shadow: 0 4px 15px -5px rgba(214, 163, 84, 0.4);
  }

  .btn-gold-prestige {
    background: var(--primary-gold);
    color: var(--deep-green);
    padding: 22px;
    border-radius: 4px;
    font-weight: 900;
    text-transform: uppercase;
    letter-spacing: 3px;
    font-size: 12px;
    transition: all 0.4s cubic-bezier(0.165, 0.84, 0.44, 1);
    margin-top: 40px;
    box-shadow: 0 20px 40px rgba(214, 163, 84, 0.2);
  }

  .btn-gold-prestige:hover {
    transform: translateY(-3px);
    filter: brightness(1.1);
    box-shadow: 0 25px 50px rgba(214, 163, 84, 0.3);
  }

  .fade-up {
    animation: fadeUp 1.2s cubic-bezier(0.165, 0.84, 0.44, 1) forwards;
  }

  @keyframes fadeUp {
    from {
      opacity: 0;
      transform: translateY(30px);
    }

    to {
      opacity: 1;
      transform: translateY(0);
    }
  }
</style>

<div class="login-cinematic">
  <div class="login-glass-container fade-up">

    <!-- Cinematic Visual Side -->
    <div class="branding-side">
      <div class="branding-content">
        <img src="<?php echo esc_url(get_template_directory_uri() . '/assets/logo.png'); ?>" alt="Trade Expansion"
          class="h-10 w-auto mb-20 opacity-40 grayscale brightness-200">
        <h1 class="text-6xl font-bold text-white leading-[0.9] mb-8 tracking-tighter">
          Technical<br><span class="text-primary-gold italic font-normal tracking-normal">Excellence.</span>
        </h1>
        <p class="text-white/30 text-xl leading-relaxed font-light italic max-w-sm">
          <?php _e('Curaduría técnica de materiales ornamentais. Un portal exclusivo para socios globales.', 'tradeexpansion'); ?>
        </p>
      </div>

      <div class="relative z-10 text-[9px] uppercase tracking-[0.5em] text-white/20 font-black">
        Est. 2026 &bull; Trade Expansion Premium
      </div>
    </div>

    <!-- Professional Form Side -->
    <div class="form-side">
      <div class="mb-16">
        <span class="editorial-tag">Privé Access</span>
        <h2 class="text-4xl font-bold text-white mb-3 tracking-tight"><?php _e('Bienvenido', 'tradeexpansion'); ?></h2>
        <p class="text-white/30 text-sm italic">
          <?php _e('Inicie sesión para acceder a su portafolio exclusivo.', 'tradeexpansion'); ?></p>
      </div>

      <?php if ($status_message): ?>
        <div
          class="mb-10 p-5 rounded-lg border <?php echo $status_message['type'] === 'success' ? 'border-emerald-500/20 bg-emerald-500/5 text-emerald-400' : 'border-rose-500/20 bg-rose-500/5 text-rose-400'; ?> text-[10px] font-black uppercase tracking-[0.2em]">
          <?php echo esc_html($status_message['text']); ?>
        </div>
      <?php endif; ?>

      <?php if ($already_logged): ?>
        <div class="space-y-8">
          <div class="p-10 rounded-2xl border border-white/5 bg-white/2">
            <span class="luxury-label mb-4"><?php _e('Sesión Activa', 'tradeexpansion'); ?></span>
            <p class="text-2xl text-white mb-10">
              <?php echo esc_html($current_user->display_name ?: $current_user->user_login); ?></p>

            <a href="<?php echo esc_url(home_url('/dashboard/')); ?>" class="block btn-gold-prestige text-center mb-6">
              <?php _e('Entrar al Panel', 'tradeexpansion'); ?>
            </a>

            <form method="POST" action="<?php echo esc_url(admin_url('admin-post.php')); ?>">
              <input type="hidden" name="action" value="te_client_logout">
              <?php wp_nonce_field('te_client_logout', 'te_client_logout_nonce'); ?>
              <button type="submit"
                class="w-full text-white/20 hover:text-rose-400 text-[10px] uppercase font-black tracking-[0.3em] transition-colors">
                <?php _e('Cerrar Sesión', 'tradeexpansion'); ?>
              </button>
            </form>
          </div>
        </div>
      <?php else: ?>
        <form method="POST" action="<?php echo esc_url(admin_url('admin-post.php')); ?>" class="space-y-10">
          <input type="hidden" name="action" value="te_client_login">
          <?php wp_nonce_field('te_client_login', 'te_client_nonce'); ?>

          <div class="space-y-4">
            <label class="luxury-label"><?php _e('Identificación', 'tradeexpansion'); ?></label>
            <input type="text" name="username" required class="minimal-input" placeholder="id@client.com">
          </div>

          <div class="space-y-4">
            <label class="luxury-label"><?php _e('Código de Acceso', 'tradeexpansion'); ?></label>
            <input type="password" name="password" required class="minimal-input"
              placeholder="&bull;&bull;&bull;&bull;&bull;&bull;&bull;&bull;">
          </div>

          <div class="flex items-center justify-between pt-4">
            <label class="flex items-center gap-4 cursor-pointer group">
              <input type="checkbox" name="remember"
                class="w-4 h-4 rounded-none border-white/10 bg-transparent text-primary-gold focus:ring-0 checked:bg-primary-gold">
              <span
                class="text-[10px] uppercase tracking-widest text-white/20 group-hover:text-white/50 transition"><?php _e('Recordar', 'tradeexpansion'); ?></span>
            </label>
            <a href="#"
              class="text-[9px] text-white/10 uppercase font-black tracking-[0.3em] hover:text-primary-gold transition"><?php _e('Soporte Privado', 'tradeexpansion'); ?></a>
          </div>

          <button type="submit" class="w-full btn-gold-prestige">
            <?php _e('Autenticar Acceso', 'tradeexpansion'); ?>
          </button>
        </form>
      <?php endif; ?>
    </div>

  </div>
</div>

<?php get_footer(); ?>