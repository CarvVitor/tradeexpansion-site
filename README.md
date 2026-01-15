<<<<<<< HEAD
# Trade Expansion LTDA – Website Institucional  
[![License: MIT](https://img.shields.io/badge/License-MIT-blue.svg)](LICENSE)  
[![Version](https://img.shields.io/badge/Version-1.0.0-green.svg)]  

**Domínio / Projeto:** [www.tradeexpansion.com.br](https://www.tradeexpansion.com.br)  
**Tema:** WordPress.org – Tema personalizado “Trade Expansion”  
**Objetivo:**  
- Migrar o site do WordPress.com para WordPress.org (reduzir custo).  
- Publicar o código no GitHub (tema personalizado + README técnico).  
- Modernização do front-end com Tailwind e identidade forte.

---

## 📌 Visão Geral  

## 1. Visão Geral  
- Migrar site do WP.com para WP.org (reduzir custo).  
- Publicar código no GitHub (tema personalizado + README técnico).  
- Manter identidade da marca + melhorar front-end (mais fluido, mais premium).  
- Página bilíngue (PT/EN) preparada.  
- Estilo visual sofisticado: cores da marca + fonte Volkhorn + layouts fluídos.

---

## 2. Identidade Visual  
| Elemento | Valor |
|----------|--------|
| Cor Primária         | `#484942` |
| Cor Texto            | `#E1E2DA` |
| Cor Secundária       | `#102724` |
| Cor de Realce (Accent) | `#5D2713` |
| Custom Colors        | `#F1F1D9` |
| Fonte                | “Volk(h)orn” (Google Fonts) |

---

## 3. Estrutura Técnica  
- WordPress.org instalado localmente (por exemplo via LocalWP).  
- Tema customizado dentro de `/wp-content/themes/tradeexpansion/`.  
- Tailwind CDN em `header.php` + configuração de cores/fonte.  
- Tema reconhecido pelo WordPress (via `style.css` cabeçalho tema).  
- Estrutura completa: `header.php`, `footer.php`, `index.php`, `functions.php`, templates de página.

---

## 4. Páginas e Layouts definidos  
### Home (index.php)  
- Hero Section com título, subtítulo e botão CTA.  
- Seção “Sobre a Trade Expansion”.  
- Seção “Serviços / Commodities” (cards: exportação de rochas, intermediação, inspeção).  
- Seção “Contato” com formulário leve (nome, e-mail, mensagem).  
- FAQ (Perguntas Frequentes) com comportamento de abrir/fechar.

### Template “Rochas Ornamentais” (page-rochas.php)  
- Hero vídeo com fallback de imagem.  
- Seção categorias (Mármores, Granitos, Quartzitos, Quartzos).  
- Seção Catálogo para download de PDF.  
- CTA “Veja nosso catálogo”.

### Template “Inspeção Técnica” (page-inspecao.php)  
- Hero Section com chamada “Inspeção de Rochas com Precisão Global”.  
- Processo de inspeção dividido em etapas visuais (Auditoria de Campo, Análise Laboratorial, Relatório & Logística).

---

## 5. Funcionalidades Futuras / Pipeline  
- Sistema multilíngue (PT/EN) via `.po/.mo`, `load_theme_textdomain()`, `__()` / `_e()`.  
- Widget “Petra” (IA): assistente de contato, multilingue, coleta de dados de lead.  
- Integração de vídeo hero externa ou auto-hospedado (vídeo de fundo).  
- Ajustes visuais finos (cores, contrastes, tipografia refinada) depois da estrutura pronta.  
- Otimização de performance (compressão de vídeo, lazy-load de imagens) antes do lançamento.

---

## 6. Como Trabalhar no Projeto  
1. Clone o repositório GitHub.  
2. Instale localmente via LocalWP (ou XAMPP) com PHP 8.x / MySQL 8.x.  
3. Ative o tema “Trade Expansion“.  
4. Adicione as páginas definidas (Home, Sobre, Rochas, Inspeção, Contato).  
5. Substitua vídeos, imagens, documentos conforme definido.  
6. Teste no desktop e mobile responsivo.  
7. Após estrutura pronta, passe para fase de refinamento visual.  
8. Faça commit e push frequentemente, com mensagens claras.

---

## 7. Contato para Suporte  
**Responsável do Projeto:** Vitor Carvalho – Empresário  
Se precisar de alguma correção, dúvida técnica ou alterar identidade visual, entre em contato para alinharmos.

---

> **Nota:** Este README é documento vivo – conforme o site avança, adicionaremos seções como “Performance”, “Implementação de SEO”, “Documentação de API da Petra”, “Versionamento e Deploy”.

---
