# theme_edukkare

Tema oficial do **Edukkare-LMS** — filho de Boost, paleta indigo + stone, tipografia Inter, geometria minimalista.

## Estrutura

```
public/theme/edukkare/
├── version.php          # Declaração do plugin
├── config.php           # Parents=[boost], hooks SCSS, layouts herdados
├── lib.php              # Callbacks de pre_scss e extra_scss
├── settings.php         # Tela de admin (cor, logos, login background, SCSS livre)
├── lang/
│   ├── en/theme_edukkare.php
│   └── pt_br/theme_edukkare.php
├── scss/
│   ├── pre.scss         # Tokens (cores, fontes, raios) — ANTES do Boost
│   └── post.scss        # Regras de componentes — DEPOIS do Boost
├── pix/
│   ├── logo.svg         # Wordmark padrão
│   ├── logocompact.svg  # Símbolo "e" para favicon/menu colapsado
│   └── favicon.svg
└── README.md
```

## Instalação

1. **Copiar o plugin** (já feito — está em `public/theme/edukkare/`).
2. **Aplicar defaults da marca** (nome do site, idioma, tema ativo, política de senha):

   ```bash
   bash branding/apply-edukkare-defaults.sh
   ```

   ou, dentro do container Docker:

   ```bash
   docker compose exec web bash /var/www/html/branding/apply-edukkare-defaults.sh
   ```

3. **Disparar a instalação do tema** pelo Moodle (cria entradas na tabela `mdl_config_plugins`):

   ```bash
   php public/admin/cli/upgrade.php --non-interactive
   ```

4. **Purgar caches**:

   ```bash
   php public/admin/cli/purge_caches.php
   ```

5. **Configurar SMTP** (credenciais devem vir por canal seguro):
   `Administração do site → Servidor → E-mail → Configuração de e-mails enviados`

## Personalização pela UI

`Administração do site → Aparência → Temas → Edukkare`

- **Cor da marca** — picker, padrão `#3730A3`
- **Logo (wordmark)** — upload SVG ou PNG
- **Logo compacto** — símbolo quadrado
- **Favicon** — ICO/PNG/SVG
- **Imagem de fundo do login** — composição abstrata recomendada
- **SCSS livre** (pre/post) — para hotfixes sem editar arquivos

## Tokens de design

A paleta e a tipografia consomem os tokens definidos em [`branding/colors.json`](../../../branding/colors.json) e descritos em [`branding/branding.md`](../../../branding/branding.md) §11. Mantenha em sincronia ao alterar.

## Modo escuro

Ativado automaticamente quando o sistema do usuário usa `prefers-color-scheme: dark` e o body tem a classe `theme-dark-allowed`. Conjunto completo de overrides em `scss/post.scss`.

## Compatibilidade

- Moodle 5.0+ (testado em 5.3dev — branch `503`)
- PHP 8.1+
- PostgreSQL 14+
- Navegadores: Edge, Firefox, Chrome (req. 55 do TER)
