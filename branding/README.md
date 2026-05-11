# Edukkare-LMS — Brand System

Identidade visual oficial da **EDUKKARE** aplicada ao produto **Edukkare-LMS** (Moodle forkado + SIS próprio).

## Resumo da direção criativa

| Eixo | Decisão |
|---|---|
| Estilo | Minimalismo moderno (Stripe / Linear / Vercel) |
| Cor primária | Indigo `#3730A3` |
| Neutros | Família Stone (cinzas quentes) |
| Acento | Amber `#F59E0B`, uso ≤5% |
| Tipografia UI | Inter (OFL) |
| Tipografia certificados | Fraunces (OFL) |
| Geometria | Raios 6/8/12/16px, três níveis de sombra |
| Logo | Wordmark "edukkare" caixa baixa, sem símbolo no MVP |

## Arquivos desta pasta

- **[`branding.md`](./branding.md)** — documento mestre com todos os campos preenchidos. Itens marcados `[A PREENCHER]` aguardam dados administrativos do Paulo (CNPJ, endereço, SMTP, contas das lojas).
- **[`colors.json`](./colors.json)** — paleta completa em formato consumível por código (tema Moodle, app mobile, geração de PDFs).
- **`logos/`** — *a criar* — logos institucionais nos formatos descritos em `branding.md` §4.2
- **`fonts/`** — *opcional* — Inter, Fraunces e JetBrains Mono são gratuitas via Google Fonts, mas pode-se hospedar localmente para ambientes air-gapped
- **`images/`** — *a criar* — imagens institucionais (login, home, 404)
- **`app-mobile/`** — *a criar* — ícones e splash do app
- **`legal/`** — *a criar* — políticas, termos e LGPD
- **`certificados/`** — *a criar* — modelo visual

## Próximos passos

1. **Validar a direção** com o Paulo (cores, tipografia, estilo wordmark).
2. **Produzir os logos** — wordmark + símbolo "e" da marca em SVG vetorial.
3. **Preencher itens `[A PREENCHER]`** em `branding.md`.
4. **Implementar `theme_sisrj`** consumindo `colors.json` e os tokens de design.
5. **Forkar o Moodle App** e aplicar o mesmo sistema visual.

## O que NÃO ficou aqui

- Senhas, chaves de API, credenciais SMTP — vão por canal seguro separado (1Password, Bitwarden).
- Brasão do TJRJ / EMEDI — adicionado por cliente, não pela marca-mãe Edukkare.
- Documentos jurídicos finalizados — gerados sob aprovação do DPO em pasta `legal/`.
