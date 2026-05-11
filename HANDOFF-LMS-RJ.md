# LMS-RJ — Documento de Handoff

Documento consolidado com a análise do TER da EMEDI/TJRJ, decisões de arquitetura e estudo da documentação do Moodle. Use este arquivo como ponto de partida para continuar o trabalho em outra sessão/projeto.

---

## 1. Contexto do projeto

**Cliente alvo:** EMEDI — Escola de Mediação do Estado do Rio de Janeiro (vinculada ao TJRJ — Tribunal de Justiça do Estado do Rio de Janeiro).

**Documento base:** `TER-RIO.docx` — Estudo Técnico Preliminar da Contratação (processo SEI nº 2024-06140426).

**Objeto da contratação:** ERP de Gestão Educacional em modelo SaaS, com integração nativa de funcionalidades de:
- AVA (Ambiente Virtual de Aprendizagem)
- LMS (Learning Management System)
- SGE / SIS (Sistema de Gestão Educacional / Student Information System)

**Escopo:** implantação, parametrização, migração de dados, customização, capacitação, manutenção e suporte técnico.

**Volumetria:** até 3.000 licenças (pico simultâneo medido em 2024 foi de 1.602 usuários).

**Valor estimado:** R$ 1.431.095,50.

**Vigência do contrato:** 28 meses, prorrogável.

**Prazo de implantação:** 90 dias corridos após aprovação do Plano de Trabalho (entregue em até 30 dias após memorando de início).

---

## 2. Necessidades de negócio (resumo)

A EMEDI atende cursos livres, eventos formativos, ensino híbrido e pós-graduação lato sensu. Cresceu para 4.900+ inscrições e 3.500 estudantes impactados, mas opera sem solução tecnológica integrada — daí a contratação.

A solução precisa entregar:
- Modelo SaaS (assinatura, sem infraestrutura local da EMEDI)
- Hospedagem dedicada **no Brasil** (LGPD)
- Aplicação e banco **dedicados** (vedado compartilhamento com outros clientes)
- App Web + Android + iOS
- Conformidade LGPD
- Capacidade para crescimento progressivo

---

## 3. Requisitos OBRIGATÓRIOS (essenciais)

### Plataforma

| # | Requisito |
|---|---|
| 01 | ERP+LMS nativamente integrados (sem integração externa entre fornecedores) |
| 02 | Certificados de Segurança SSL |
| 03 | Modelo SaaS (Software as a Service) |
| 05 | Sistema de balanceamento de carga para vídeo |
| 06 | Ambiente operacional 64 bits |
| 09 | Inteligência artificial (busca de materiais, resumo de texto, questionários, reconhecimento facial) |
| 10 | HTTPS e Web Services (WSDL, SOAP) |
| 11 | Arquitetura escalável e resiliente |
| 12 | Aplicação e banco de dados **dedicados** |
| 13 | Integração total entre módulos e BD na nuvem |
| 14 | **Hospedagem em nuvem somente no Brasil** |
| 15 | Chat nativo para chamados |
| 16 | App Web, Android e iOS para alunos e gestores |
| 17 | Autenticação por senha |
| 18 | Integração nativa entre recursos |
| 19 | Balanceamento entre servidores de aplicação |
| 20 | Backup diário |
| 25 | Servidor de autenticação dedicado com criptografia |
| 27 | Conformidade com **LGPD** |
| 28 | Importação de dados legados (.xls/.csv/.xml/BD) |
| 29 | Adequação a ensino presencial, virtual e híbrido |
| 30 | Performance independente de usuários simultâneos |
| 31 | Bloqueio de usuários |
| 32 | Parametrização individualizada (notas, avisos, biblioteca) |
| 33 | Aluno em uma ou mais turmas |
| 35 | Matrícula única por aluno |
| 37 | Acesso para Alunos, Gestores, Professores, Diretores e Funcionários |
| 40 | Atualização de dados em tempo real |
| 41 | Documentação em português do Brasil |
| 42 | Vídeo aula sem cobrança por tempo |
| 43 | Tradutor PT/EN/ES |
| 44 | Bancos dedicados por serviço |
| 45 | Perfis de acesso por tipo de usuário |
| 46 | Geração e controle de login/senha |
| 47 | Leitura de QR Code |
| 48 | Videoconferência com salas menores (breakout rooms) |
| 51 | Plataforma de cursos livres com certificação no currículo |
| 52 | Controle de acesso via QR Code |
| 53 | Plataforma de eventos/seminários/congressos com certificados digitais |
| 54 | Plataforma de formações com certificados digitais |
| 55 | Compatível com Edge, Firefox, Chrome |
| 56 | Layout responsivo (tablets/smartphones) |

### App móvel

| # | Requisito |
|---|---|
| 1 | Compatível iOS 11+ e Android 5.1+ |
| 2 | Funciona em 3G/4G/5G e Wi-Fi |

### Segurança (item 4.5 do TER)

- MFA por e-mail institucional (ou pessoal para usuário externo)
- Senha: 12-20 caracteres, atender 3 dos 4 critérios (maiúscula, minúscula, número, especial)
- Termo de Compromisso, Sigilo e Confidencialidade
- SLA: Severidade 1 (resposta 15min/resolução 2h), Severidade 2 (1h/12h), Severidade 3 (4h/24h), todos 24x7

---

## 4. Requisitos DESEJÁVEIS

| # | Requisito |
|---|---|
| 04 | Servidores de vídeo próprios da contratada |
| 07 | Modelo White Label (logo/marca da EMEDI) |
| 08 | Suporte nativo a FTP |
| 21 | Ferramenta centralizada de monitoramento |
| 22 | Configuração de fórmulas de cálculo (média, frequência mínima) |
| 23 | Sistema de testes de performance/stress |
| 24 | Arquitetura de microsserviços |
| 26 | Base de leitura dedicada para acelerar consultas |
| 34 | Permitir e-mail pessoal (sem corporativo padronizado) |
| 36 | Apenas exclusão lógica de dados pessoais |
| 38 | Temas customizáveis por usuário |
| 39 | Envio de arquivos tipo "AirDrop" |
| 49 | Exportar PDF/XLS/DOC/PPT/CSV/XML e anexar diversos formatos |
| 50 | Ferramentas automáticas de manutenção |
| App 3 | App para Android e iOS gratuito nas lojas |
| App 4 | Vídeos no app de alunos/professores |
| App 5 | "AirDrop" no app de aluno/responsável/professor |

---

## 5. Plataformas avaliadas no TER

| Plataforma | Tipo | ERP+LMS nativo? | Open Source? |
|---|---|---|---|
| TOTVS Educacional | Proprietária | Não (precisa AVA externo) | Não |
| Gennera | Proprietária SaaS | Não (precisa LMS externo) | Não |
| Moodle | Open Source | Não (só LMS) | **Sim** |
| Canvas | LMS SaaS | Não (só LMS) | **Sim (AGPL)** |
| Blackboard Learn | Proprietária | Não (só LMS) | Não |
| SIGAA / Sistemas Públicos | Acadêmico público | Sim (SIS+Moodle) | **Parcial** |
| Conecte+Edu | Proprietária SaaS | **Sim** | Não |
| Sidle | Proprietária SaaS | **Sim** | Não |
| Erudio (Extreme Digital) | Proprietária SaaS | **Sim** | Não |

---

## 6. Decisão arquitetural: Moodle (forkado) + SIS próprio

### 6.1 Por que Moodle e não SIGAA

Como o SIS já existe (próprio), a decisão recai entre:

- **SIGAA:** boa funcionalidade, mas duplica o SIS existente. Stack pesada (Java/JBoss). Self-hosted. Modelo de dados orientado à universidade federal (não cabe perfeitamente em escola de mediação). Comunidade menor. Não tem fornecedor SaaS comercial maduro.

- **Moodle:** LMS mais maduro do mundo (~20 anos, GPL, comunidade enorme). Stack acessível (PHP + MySQL/PostgreSQL). Desenhado para integrar com SIS externo. Atende quase todos os requisitos técnicos do TER via plugins existentes.

**Conclusão:** Moodle é a melhor base para forkar. O SIS próprio cobre o lado "ERP/SGE" do TER, e o Moodle cobre o lado "AVA/LMS". Ambos integrados nativamente e operados pelo mesmo fornecedor (você) atendem o requisito 01 ("ERP+LMS nativamente integrados").

### 6.2 Estratégia para o requisito 01 ("integração nativa")

O requisito 01 é o mais crítico do TER: veda integração entre fornecedores diferentes. Como você é o fornecedor único e SIS+Moodle compartilham:
- Mesma autenticação (SSO)
- Mesma marca / front-end branded
- Mesmo banco lógico (com sincronização ativa)
- Mesmo SLA e contrato

…o conjunto pode ser apresentado contratualmente como **uma plataforma única**, não como duas soluções integradas. Esse é o mesmo argumento usado por Conecte+Edu, Sidle e Erudio — internamente também são SIS + LMS costurados.

### 6.3 Mapeamento de requisitos do TER → solução técnica no Moodle

| Requisito do TER | Solução |
|---|---|
| 09 IA (resumo, busca, quiz) | Moodle 4.5+ tem AI Subsystem (integra OpenAI, Azure) |
| 16 / App 1-5 App Android/iOS | Moodle App oficial + customização branded |
| 20 Backup diário | Nativo |
| 27 LGPD | Privacy API (obrigatória declarar em qualquer plugin) |
| 28 Importar legado | CSV upload + Web Services |
| 41 Documentação em PT-BR | Idioma nativo |
| 43 Tradutor PT/EN/ES | Idiomas nativos |
| 47/52 QR Code | Plugins de QR Attendance |
| 48 Videoconferência + breakout | BigBlueButton plugin (ou Zoom plugin) |
| 51/53/54 Certificados digitais | Plugins Custom Certificate / Certificate |
| 53 Eventos/inscrições | Face-to-Face / Booking plugin |
| 55 Browsers Edge/Firefox/Chrome | Suportado nativamente |
| 56 Layout responsivo | Tema Boost/MoodleNet responsivo |
| 4.5.1.1 MFA | Plugin oficial MFA |
| 4.5.1.2 Senha 12-20 chars com 3/4 critérios | Configuração nativa de política de senha |

---

## 7. Arquitetura proposta

```
SIS (sua plataforma própria)               Moodle Forkado (LMS)
┌─────────────────┐                       ┌──────────────────────┐
│ - Cadastro      │  ──[webhook OUT]───▶  │ local_sisrj          │
│ - Matrícula     │                       │  ├─ webhook receiver │
│ - Cursos        │                       │  ├─ sync engine      │
│ - Certificados  │                       │  └─ scheduled tasks  │
│ - Financeiro    │  ◀──[webhook IN]───── │                      │
│                 │                       │ enrol_sisrj          │
│                 │                       │  └─ provisiona       │
│                 │                       │     matrículas       │
│                 │                       │                      │
│ Identity        │  ◀──[OAuth2/JWT]────  │ auth_sisrj           │
│ Provider        │                       │  └─ SSO              │
└─────────────────┘                       │                      │
                                          │ theme_sisrj          │
                                          │  └─ white-label      │
                                          │                      │
                                          │ tool_sisrj           │
                                          │  └─ admin UI da      │
                                          │     integração       │
                                          └──────────────────────┘

      ┌──────────────────────────────────────┐
      │  Front-end único com branding (web)  │
      │  ── alterna entre SIS e Moodle ──    │
      │  ── usuário não percebe a divisão ── │
      └──────────────────────────────────────┘
```

### Componentes críticos a desenvolver

1. **`auth_sisrj`** — plugin de autenticação. SSO com o SIS (OAuth2 ou JWT). Define o SIS como fonte de verdade da identidade. Sincroniza atributos de perfil.

2. **`enrol_sisrj`** — plugin de matrícula. Quando SIS cria/cancela matrícula, dispara webhook → este plugin matricula/desmatricula no curso Moodle correspondente.

3. **`local_sisrj`** — plugin genérico que abriga:
   - Endpoints REST customizados (recebem webhooks do SIS)
   - Engine de sync bidirecional
   - Scheduled tasks (Task API) para reconciliação periódica
   - Listeners de eventos Moodle (notas, conclusão) que disparam webhook OUT para o SIS

4. **`theme_sisrj`** — tema custom para white-label.

5. **`tool_sisrj`** — telas administrativas da integração (logs de sync, status de webhooks, retry manual).

### Mobile

O Moodle App é um projeto separado (Ionic + Angular) no repo `moodle/moodleapp`. Para white-label:
- Forkar o repo
- Customizar `src/theme`, `src/assets`, `config.xml`, ícones
- Build via Ionic CLI
- Publicar nas lojas Apple/Google com identidade da EMEDI/TJRJ

---

## 8. Documentação Moodle estudada

### Stack Moodle

- **PHP** (7.4+ para 4.x, 8.1+ para 5.x)
- **Banco:** MySQL/MariaDB, PostgreSQL, MSSQL, Oracle
- **Versão atual:** Moodle 5.2
- **Releases majors:** ~6 meses
- **Convenção de nomes:** "Frankenstyle" — `<plugintype>_<pluginname>` (ex: `auth_sisrj`)

### Plugin types relevantes

| Plugin type | Pasta | Uso no projeto |
|---|---|---|
| `auth` | `/auth` | SSO com SIS |
| `enrol` | `/enrol` | Provisionamento de matrícula |
| `local` | `/local` | Lógica de integração genérica |
| `theme` | `/theme` | White-label |
| `tool` | `/admin/tool` | UI admin |
| `webservice` | `/webservice` | Custom REST/SOAP (raramente necessário, usar External Services API) |

### APIs centrais relevantes

| API | Uso |
|---|---|
| **External Services** | Expor funções para o SIS chamar (`db/services.php`) |
| **Enrolment API** | Gerenciar matrículas programaticamente |
| **Authentication plugins** | SSO |
| **OAuth 2 API** | Integração com IdP do SIS |
| **Events API** | Listeners de eventos do core |
| **Hooks API** (5.0+) | Forma moderna de comunicação entre plugins |
| **Task API** | Cron jobs (sync periódico) |
| **Privacy API** | LGPD compliance — obrigatório em todo plugin |
| **Custom fields API** | Adicionar atributos do SIS sem mexer no core |
| **Web services** | Funções pré-existentes: `core_user_create_users`, `enrol_manual_enrol_users`, `core_course_create_courses`, `gradereport_user_get_grade_items` |

### Padrões de arquivos por plugin

Todo plugin tem no mínimo:
- `version.php` — metadata e versão
- `lang/en/<plugin>.php` — strings (e `lang/pt_br/...`)
- `db/install.xml` — schema do banco (se cria tabelas)
- `db/upgrade.php` — migrações
- `db/services.php` — declaração de web services (se aplicável)
- `db/access.php` — capabilities
- `classes/...` — código PSR-4

### Boas práticas para o fork

1. **Não tocar no core** — toda customização em plugin. Facilita merge upstream.
2. **Seguir coding standards** — `phpcs` próprio do Moodle.
3. **Cobertura de testes** — PHPUnit + Behat.
4. **Política de upgrade do fork** — decidir se acompanha majors do upstream ou só patches de segurança.

### Links de referência

- **Site:** https://moodledev.io/
- **API guides 5.2:** https://moodledev.io/docs/5.2/apis
- **External Services:** https://moodledev.io/docs/5.2/apis/subsystems/external
- **Writing a web service:** https://moodledev.io/docs/5.2/apis/subsystems/external/writing-a-service
- **Enrolment API:** https://moodledev.io/docs/5.2/apis/subsystems/enrol
- **Plugin types:** https://moodledev.io/docs/5.2/apis/plugintypes
- **Local plugins:** https://moodledev.io/docs/5.2/apis/plugintypes/local
- **Privacy API (LGPD):** https://moodledev.io/docs/5.2/apis/subsystems/privacy
- **OAuth 2 API:** https://docs.moodle.org/dev/OAuth_2_API
- **Authentication plugins:** https://docs.moodle.org/dev/Authentication_plugins
- **Hooks API:** https://moodledev.io/docs/5.2/apis/core/hooks
- **Task API:** https://moodledev.io/docs/5.2/apis/subsystems/task
- **Moodle App (mobile):** https://moodledev.io/general/app
- **Coding standards:** https://moodledev.io/general/development/policies/codingstyle
- **Getting started:** https://moodledev.io/general/development/gettingstarted
- **Repos:** https://github.com/moodle
- **Tracker:** https://moodle.atlassian.net
- **Diretório de plugins:** https://moodle.org/plugins

---

## 9. Próximos passos

1. **Detalhar o SIS atual:** stack, modelo de dados (aluno, curso, matrícula, certificado), autenticação, APIs já expostas.
2. **Mapear entidades SIS ↔ Moodle:**
   - SIS.aluno ↔ `mdl_user`
   - SIS.curso ↔ `mdl_course`
   - SIS.matrícula ↔ `mdl_user_enrolments`
   - SIS.certificado ↔ certificate plugin
3. **Definir contrato de webhooks** (eventos, payload, autenticação, retry).
4. **Decidir IdP:** o SIS é o IdP único? Ou Moodle pode autenticar local também (fallback)?
5. **Esqueleto dos plugins:** criar `auth_sisrj`, `enrol_sisrj`, `local_sisrj` com `version.php`, `lang/`, `db/services.php` mínimo.
6. **Plano de white-label:** branding do site Moodle (`theme_sisrj`) + fork do Moodle App.
7. **Checklist de aderência ao TER:** marcar item por item dos requisitos essenciais e desejáveis com a solução técnica correspondente — material para a proposta comercial.
8. **Plano de implantação em 90 dias:** alinhar etapas do TER (Plano de Trabalho → Parametrização → Carga → Testes → Capacitação → Go Live → Estabilização) com cronograma técnico.
9. **Política de fork:** decidir branch/tag base do Moodle e estratégia de rebase contra upstream.
10. **SLA e infraestrutura:** definir provedor IaaS no Brasil (AWS São Paulo, Azure Brasil, Magalu Cloud, etc.), arquitetura de alta disponibilidade, monitoramento (atende item 21 desejável e SLAs de severidade do TER).

---

## 10. Riscos e pontos de atenção

- **Requisito 12 (banco dedicado por cliente):** força arquitetura multi-tenant onde cada contrato tem instância isolada. Impacta custo de infra.
- **Requisito 14 (hospedagem só no Brasil):** restringe escolha de provedor. AWS/Azure/GCP têm regiões em SP, mas verificar custo.
- **Requisito 24 desejável (microsserviços):** conflita parcialmente com Moodle (monolito PHP). Argumentar que arquitetura é "modular via plugins" e que serviços auxiliares (videoconferência, mídia, busca) são independentes.
- **Item 9 (IA):** verificar Moodle AI Subsystem em detalhe; pode exigir contrato com OpenAI/Azure (custo recorrente).
- **Item 4 desejável (servidores de vídeo próprios):** se for atendido, exige investimento em infraestrutura de streaming (HLS/DASH) ou contratar serviço gerenciado.
- **Direitos autorais sobre fork:** ao customizar Moodle (GPL), publicar fork em GitHub privado é ok; se redistribuir binários, GPL exige liberar código.
- **Manutenção do fork:** divergências cumulativas com upstream tornam upgrades cada vez mais caros. Idealmente, todo código novo vai em plugin separado.

---

*Documento gerado a partir da análise do TER-RIO.docx e estudo da documentação oficial em moodledev.io.*
