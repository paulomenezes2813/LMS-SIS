# Branding — Edukkare-LMS

Identidade de marca **EDUKKARE** aplicada ao produto **Edukkare-LMS** (Moodle forkado + SIS próprio).
Diretriz de design: minimalismo moderno, tipografia neutra, paleta restrita, alta legibilidade. Inspiração de referência: Stripe, Linear, Vercel, Notion — ferramentas profissionais B2B com presença visual sóbria.

> **Legenda dos campos**
> - Valores em texto regular: definidos pela direção de marca (gerados nesta etapa).
> - `[A PREENCHER]`: dados administrativos/jurídicos que precisam vir do Paulo.
> - Senhas e credenciais nunca ficam neste arquivo — vão por canal seguro.

---

## 1. Identidade institucional

| Campo | Valor |
|---|---|
| Razão social | `[EDUKKARE PEDTECH LTDA]` (sugestão: EDUKKARE TECNOLOGIA EDUCACIONAL LTDA) |
| Nome fantasia | EDUKKARE |
| CNPJ | `[55.662.048/0001-57]` |
| Endereço completo (sede) | `[Rua Monsenhor Bruno, 1153, Sala 128, Aldeota — Fortaleza/CE]` |
| Site institucional | https://edukkare.com.br |
| LinkedIn | https://linkedin.com/company/edukkare |
| Instagram | @edukkare |
| X / Twitter | @edukkare |

## 2. Identidade do produto

| Campo | Valor | Observação |
|---|---|---|
| Nome do produto (LMS) | Edukkare-LMS | Forma escrita oficial — "Edukkare" + hífen + "LMS" em caixa alta. Pronuncia-se /e.du'ka.ɾi/ ou /ɛˈduːkɐrɛ/ (livre ao usuário) |
| Nome do produto (SIS) | Edukkare-SIS | Mesma família, sufixo distinto |
| Plataforma combinada | Edukkare | Quando referenciado como solução única (LMS+SIS), usa-se apenas a marca-mãe |
| Slogan oficial | **Tecnologia que educa.** | Curto, com ponto final, transmite autoridade |
| Slogan alternativo (mercado público) | Plataforma educacional integrada | Para uso em propostas e editais |
| Descrição curta (até 80 caracteres) | Plataforma integrada de gestão e aprendizado para instituições de ensino. |
| Descrição longa (até 300 caracteres) | Edukkare-LMS é uma plataforma educacional ponta a ponta que integra gestão acadêmica (SIS) e ambiente virtual de aprendizagem (LMS) em uma única experiência. Atende cursos livres, formações, eventos e pós-graduação, com app web, Android e iOS. |

## 3. Domínios e URLs

| Campo | Valor |
|---|---|
| Domínio do produto institucional | edukkare.com.br |
| Domínio do LMS (multi-tenant padrão) | `{cliente}.edukkare.com.br` (ex: emedi.edukkare.com.br) |
| Domínio do SIS (multi-tenant padrão) | `{cliente}.edukkare.com.br/sis` ou subdomínio dedicado |
| Subdomínio de mídia/CDN | media.edukkare.com.br |
| Subdomínio de status | status.edukkare.com.br |
| Política de Privacidade | https://edukkare.com.br/privacidade |
| Termos de Uso | https://edukkare.com.br/termos |
| Suporte / Central de ajuda | https://ajuda.edukkare.com.br |

## 4. Identidade visual

### 4.1 Linguagem de design

- **Estilo:** minimalista funcional. Evitar gradientes pesados, sombras dramáticas, ícones decorativos. Preferir bordas finas (1px), espaçamento generoso, hierarquia tipográfica como elemento gráfico principal.
- **Logo:** wordmark "edukkare" em caixa baixa, sem símbolo separado na primeira versão. Letterspacing levemente apertado (-0.02em). Substitui-se a primeira letra `e` por uma versão com leve abertura caligráfica como traço de marca (a definir em arte final).
- **Geometria:** raios de canto suaves — 8px (botões e inputs), 12px (cards), 16px (modais e containers grandes). Nunca `border-radius: 9999px` exceto em avatares e badges de status.
- **Sombras:** apenas três níveis — `xs` (2 1 4 / 0.04), `sm` (4 2 8 / 0.06), `md` (12 4 24 / 0.08). Acima disso, usar borda em vez de sombra.

### 4.2 Logos (entregar em `branding/logos/`)

| Arquivo | Especificação | Observação |
|---|---|---|
| `logo-principal.svg` | Wordmark horizontal, cor primária sobre transparente | Versão padrão para header desktop |
| `logo-principal.png` | Mesmo wordmark, 4000x1200 transparente | Fallback raster |
| `logo-compacto.svg` | Símbolo da inicial "e" da marca, 1:1 | Para favicon, app icon, menu colapsado |
| `favicon.ico` | 16/32/48 multi-resolução | Gerado a partir do logo-compacto |
| `logo-mono.svg` | Versão preto puro 100% (#000000) | PDFs, certificados, documentos |
| `logo-darkbg.svg` | Versão branca para fundos escuros | Modo escuro do app |
| `assinatura-digital.png` | PNG transparente, 600x200 | Rodapé de certificado |

### 4.3 Cores

Paleta completa em [`colors.json`](./colors.json). Resumo:

- **Primária:** `#3730A3` Indigo profundo — confiança, intelectualidade, sobriedade institucional. Usado em botões primários, links, header e elementos de marca.
- **Neutros:** família **Stone** (cinzas quentes) em vez de Slate puro — adiciona calor humano sem perder seriedade. Diferencial em relação a concorrentes que abusam de azul-cinza estéril.
- **Acento:** `#F59E0B` Amber — usado com extrema moderação (≤5% da interface). Reservado para destaques de progresso, badges de conquista, estados informativos positivos sem ser "verde de sucesso".
- **Semânticos:** verde Emerald `#10B981` (sucesso), amber `#F59E0B` (alerta), vermelho `#EF4444` (erro), azul `#3B82F6` (informação).

### 4.4 Tipografia

| Uso | Família | Pesos | Licença |
|---|---|---|---|
| Corpo + UI | **Inter** | 400, 500, 600, 700 | SIL Open Font License (gratuita, comercial) |
| Títulos display | **Inter** (mesmo arquivo, peso 700/800 + tracking ajustado) | 700, 800 | OFL |
| Monoespaçada (códigos, IDs) | **JetBrains Mono** | 400, 500 | OFL |
| Certificados (toque elegante) | **Fraunces** | 400, 600 (apenas para o nome do aluno) | OFL |

Justificativa: Inter é o padrão de fato do design profissional em 2026 — usada por Vercel, Linear, GitHub, Stripe Dashboard. Resolve problemas de leitura em UI densa. Fraunces nos certificados adiciona um traço de tradição acadêmica sem cair em fontes serifadas datadas.

Carregar via Google Fonts (CDN próprio do Moodle e do app):
```
https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&family=JetBrains+Mono:wght@400;500&family=Fraunces:wght@400;600&display=swap
```

## 5. Imagens institucionais

| Imagem | Dimensões | Direção criativa |
|---|---|---|
| Banner de login | 1920x1080 | Composição abstrata geométrica em tons da paleta primária. Sem fotos de pessoas (evita perfil etário/cultural). Sem texto sobre a imagem. |
| Banner da home (autenticado) | 1920x600 | Padrão sutil/textura monocromática indigo, baixíssimo contraste para não competir com cards. |
| Imagem de erro 404 | 1200x800 | Ilustração linha-arte minimalista de um livro aberto com páginas em branco. Cor única (indigo). |
| Imagem de manutenção | 1200x800 | Ilustração linha-arte: ícone de chave ou ampulheta, mesmo estilo do 404. |
| Avatar default de usuário | 512x512 | Iniciais do nome em fundo de cor gerada deterministicamente do nome (algoritmo padrão tipo Boring Avatars). |
| Open Graph (compartilhamento) | 1200x630 | Wordmark + slogan centralizado em fundo indigo, texto branco. Padrão Stripe-like. |

## 6. Comunicação por e-mail

| Campo | Valor |
|---|---|
| Nome do remetente | Edukkare |
| E-mail de remetente padrão | nao-responda@edukkare.com.br |
| E-mail de suporte (visível ao usuário) | suporte@edukkare.com.br |
| E-mail comercial | comercial@edukkare.com.br |
| E-mail jurídico/DPO | dpo@edukkare.com.br |
| Servidor SMTP (host) | `[A PREENCHER]` (sugestão: AWS SES, SendGrid ou Postmark) |
| Porta SMTP | 587 (STARTTLS) |
| Criptografia | STARTTLS |
| Usuário SMTP | `[A PREENCHER]` |
| Senha SMTP | **Enviar por canal seguro separado** |
| Cabeçalho HTML padrão | Logo `logo-principal.svg` (60px altura) sobre fundo `#FAFAF9`, padding 32px |
| Rodapé HTML padrão | "Edukkare · Tecnologia que educa." em texto cinza-stone-500, 12px, centralizado. Links de "Suporte", "Privacidade" e "Cancelar inscrição" separados por `·`. CNPJ e endereço em letra menor (10px). |

## 7. App mobile (fork do Moodle App)

| Campo | iOS | Android |
|---|---|---|
| Nome nas lojas | Edukkare | Edukkare |
| Bundle ID / Package | `com.edukkare.lms` | `com.edukkare.lms` |
| Conta de publicação | Apple Developer Program — `[A PREENCHER]` | Google Play Console — `[A PREENCHER]` |
| Descrição curta (30 caracteres) | Aprender, em qualquer lugar. | Aprender, em qualquer lugar. |
| Descrição longa (≤4000 caracteres) | Ver template `app-mobile/store-description.md` | Ver template `app-mobile/store-description.md` |
| Categoria principal | Educação | Educação |
| Categoria secundária | Produtividade | Produtividade |
| Idade mínima (rating) | 12+ | Classificação livre L (ou 12+ a definir) |
| Política de privacidade (URL) | https://edukkare.com.br/privacidade | https://edukkare.com.br/privacidade |
| Vídeo de demonstração | `[A GRAVAR]` 30s mostrando login → curso → aula → certificado |

### 7.1 Assets do app

| Arquivo | Especificação | Direção |
|---|---|---|
| `icon-1024.png` | 1024x1024, sem transparência (iOS) | Símbolo "e" da marca em branco sobre fundo indigo `#3730A3` sólido. Sem brilhos, sem sombras, sem gradiente. |
| `android-adaptive-foreground.png` | 432x432 PNG transparente | Mesmo símbolo "e" com 25% de safe-zone interno |
| `android-adaptive-background.png` | 432x432 cor sólida | Indigo `#3730A3` sólido |
| `splash-1242x2688.png` | Logo centralizado | Wordmark "edukkare" branco centralizado em fundo indigo `#3730A3`. Sem loading spinner — apenas a marca por 800ms. |
| Screenshots iOS | 6.7" / 6.5" / 5.5" | 5 frames: login, lista de cursos, aula em vídeo, quiz, perfil/certificados |
| Screenshots Android | Phone + Tablet 7" + Tablet 10" | Mesmos 5 frames adaptados |

## 8. Conteúdo legal e institucional

| Campo | Valor / arquivo |
|---|---|
| Política de Privacidade (LGPD) | `legal/politica-privacidade.md` — gerar a partir do [template ANPD](https://www.gov.br/anpd/) e do escopo Edukkare |
| Termos de Uso | `legal/termos-uso.md` |
| Termo de Compromisso, Sigilo e Confidencialidade (req. 4.5 TER) | `legal/termo-sigilo.md` |
| Encarregado de dados (DPO) | `[A PREENCHER]` — nome, e-mail (dpo@edukkare.com.br) |
| Aviso de cookies | "Usamos cookies essenciais para o funcionamento da plataforma. Saiba mais em nossa Política de Privacidade." Apenas botões "Aceitar" e "Apenas essenciais" — sem dark pattern. |

## 9. Certificados digitais (req. 51, 53, 54 do TER)

| Campo | Valor |
|---|---|
| Modelo visual | A4 paisagem. Borda fina indigo 1pt em todo o perímetro, com 12mm de margem. Wordmark Edukkare topo-esquerda, brasão/selo do cliente topo-direita. |
| Texto padrão (frente) | "Certificamos que **{nome_aluno}** concluiu com aproveitamento o curso **{nome_curso}**, com carga horária total de **{ch} horas**, ministrado entre **{data_inicio}** e **{data_fim}**." |
| Texto padrão (verso) | Conteúdo programático, lista de tutores, declaração de validade, código de verificação e URL da página pública de validação. |
| Tipografia (nome do aluno) | Fraunces 600, 36pt |
| Tipografia (corpo) | Inter 400, 12pt |
| Cor da borda e título | Indigo `#3730A3` |
| Cor do corpo | Stone-900 `#1C1917` |
| Selo / brasão (cliente) | `[A INTEGRAR POR CLIENTE]` — para EMEDI usa brasão do TJRJ |
| Assinatura digital | `[A PREENCHER]` PNG transparente do signatário institucional |
| QR Code | Canto inferior direito, link para `https://verificar.edukkare.com.br/{hash}` |
| Hash de verificação | SHA-256 de `{cpf_aluno}:{id_curso}:{data_emissao}:{salt}` — armazenar mapping no SIS |

## 10. Configurações regionais

| Campo | Valor |
|---|---|
| Idioma principal | pt_br |
| Idiomas adicionais (req. 43 TER) | en, es |
| Fuso horário padrão | America/Sao_Paulo |
| Formato de data | dd/mm/aaaa |
| Formato de hora | 24h (HH:mm) |
| Primeiro dia da semana | Domingo |
| Moeda | BRL (R$) |

---

## 11. Tokens de design (referência para implementação)

Estes tokens devem ser materializados como variáveis CSS em `theme_sisrj/scss/_variables.scss` e como constantes no fork do Moodle App (`src/theme/variables.scss`).

```scss
// Espaçamento (escala 4px)
$space-1: 0.25rem;  $space-2: 0.5rem;  $space-3: 0.75rem;  $space-4: 1rem;
$space-6: 1.5rem;   $space-8: 2rem;    $space-12: 3rem;    $space-16: 4rem;

// Raios
$radius-sm: 6px;    $radius-md: 8px;   $radius-lg: 12px;   $radius-xl: 16px;

// Sombras
$shadow-xs: 0 1px 2px 0 rgb(0 0 0 / 0.04);
$shadow-sm: 0 2px 4px -1px rgb(0 0 0 / 0.06);
$shadow-md: 0 4px 12px -2px rgb(0 0 0 / 0.08);

// Tipografia
$font-sans: "Inter", system-ui, -apple-system, "Segoe UI", sans-serif;
$font-mono: "JetBrains Mono", ui-monospace, "SF Mono", monospace;
$font-display: "Fraunces", Georgia, serif;

$text-xs: 0.75rem;  $text-sm: 0.875rem;  $text-base: 1rem;
$text-lg: 1.125rem; $text-xl: 1.25rem;   $text-2xl: 1.5rem;
$text-3xl: 1.875rem; $text-4xl: 2.25rem;

// Transições — sempre rápidas, lineares ou ease-out
$transition-fast: 120ms ease-out;
$transition-base: 200ms ease-out;
```

## 12. Princípios de produto (resumo)

1. **Menos é mais.** Se uma tela tem mais de uma cor de marca visível, está errada.
2. **Tipografia faz hierarquia,** não decoração. Tamanhos e pesos antes de cores e bordas.
3. **Espaço em branco é design.** Não preencher por preencher.
4. **Acessibilidade não é opcional.** Contraste mínimo WCAG AA em qualquer combinação. Foco visível em todo elemento interativo.
5. **Performance é UX.** Cada asset visual deve justificar seu custo de bytes. SVG > PNG > WebP > JPEG.
6. **Marca acima de produto.** O usuário lembra de "Edukkare", não de "Edukkare-LMS-versão-2".

---

*Template preenchido em 2026-05-10 pela direção de marca Edukkare. Itens marcados `[A PREENCHER]` aguardam dados administrativos do Paulo. Versão 1.0.*
