# Backlog de conformidade ao TER-RIO (EMEDI/TJRJ)

Mapeamento item a item de cada requisito do TER para a ação técnica correspondente no Edukkare-LMS (Moodle forkado + SIS próprio). Use este documento como **checklist de entrega** e como **anexo da proposta comercial**.

## Legenda de status

| Símbolo | Significado |
|---|---|
| `✅ nativo` | Já entregue pelo core do Moodle 5.x sem desenvolvimento |
| `🔌 plugin-3p` | Atendido por plugin público (Moodle Plugins Directory) |
| `🛠 plugin-custom` | Requer desenvolvimento de plugin próprio (`*_sisrj` / `theme_edukkare`) |
| `⚙️ config` | Atendido por configuração nativa (admin/CLI) |
| `☁️ infra` | Resolvido na camada de infraestrutura (cloud, K8s, CDN) |
| `📋 operacional` | Processo/política (SLA, capacitação, suporte 24x7) |
| `🔗 integração` | Integração com SIS via webhooks/REST/SOAP |

---

## 1. Requisitos ESSENCIAIS — Plataforma

| # | Requisito do TER | Status | Ação técnica |
|---|---|---|---|
| 01 | ERP + LMS nativamente integrados | 🛠 + 🔗 | `auth_sisrj` (SSO), `enrol_sisrj` (matrícula), `local_sisrj` (webhooks), front-end branded único |
| 02 | Certificados SSL | ☁️ | ACM/AWS ou Let's Encrypt no balanceador. Forçar HSTS |
| 03 | SaaS | ☁️ + 📋 | Modelo de entrega multi-tenant. Contrato de assinatura |
| 05 | Balanceamento de carga para vídeo | ☁️ | CDN (CloudFront/Cloudflare) + adaptive bitrate (HLS) |
| 06 | Ambiente 64 bits | ☁️ | Instâncias x86_64 ou ARM64 em AWS/Azure São Paulo |
| 09 | IA (resumo, busca, quiz, reconhecimento facial) | ⚙️ + 🔌 | Moodle AI Subsystem (4.5+) com `aiprovider_openai` ou `aiprovider_azureai`. Reconhecimento facial: plugin externo ou serviço AWS Rekognition via `local_sisrj` |
| 10 | HTTPS + Web Services (WSDL/SOAP) | ✅ + 🛠 | REST nativo. SOAP/WSDL: expor via Moodle SOAP server (External Services) ou adapter custom em `local_sisrj` |
| 11 | Arquitetura escalável e resiliente | ☁️ | Kubernetes (EKS/AKS) + auto-scaling + replicação BD + multi-AZ |
| 12 | App e BD **dedicados** por cliente | ☁️ | **Crítico:** multi-tenant físico — cada contrato = instância Moodle + cluster Postgres próprios |
| 13 | Integração total entre módulos e BD na nuvem | 🛠 | Plugins `*_sisrj` mantêm sincronia bidirecional SIS ↔ Moodle |
| 14 | Hospedagem em nuvem **somente no Brasil** | ☁️ | AWS sa-east-1 (São Paulo), Azure Brazil South ou Magalu Cloud. Política de residência de dados |
| 15 | Chat nativo para chamados | 🔌 + 🔗 | Plugin `local_helpdesk` ou integração com Zendesk/Freshdesk via `local_sisrj` |
| 16 | App Web, Android e iOS | 🛠 | Moodle App (fork branded `edukkare-app`). Web já é responsivo via `theme_edukkare` |
| 17 | Autenticação por senha | ✅ | Plugin nativo `auth_manual` + política de senha |
| 18 | Integração nativa entre recursos | ✅ | Atividades core do Moodle já são integradas (gradebook, completion, calendar) |
| 19 | Balanceamento entre servidores | ☁️ | ALB/NLB + múltiplos pods Moodle + session affinity Redis |
| 20 | Backup diário | ⚙️ | Cron `admin/cli/automated_backups.php` + snapshot RDS diário |
| 25 | Servidor de autenticação dedicado com criptografia | 🛠 + ☁️ | SIS como IdP único. JWT/OAuth2 sobre TLS 1.3. Chaves em KMS |
| 27 | Conformidade LGPD | ✅ + 🔌 | Privacy API nativa + plugin `tool_policy`. DPO designado |
| 28 | Importação de dados legados (xls/csv/xml/BD) | ✅ + 🛠 | CSV upload nativo (`admin/uploaduser.php`). XLS/XML/BD via scripts em `local_sisrj` |
| 29 | Ensino presencial, virtual e híbrido | 🔌 | Plugin `mod_facetoface` (presencial) + atividades core (virtual) |
| 30 | Performance independente de usuários simultâneos | ☁️ | Auto-scaling horizontal + cache Redis + read replica Postgres |
| 31 | Bloqueio de usuários | ✅ | `Administração do site → Usuários → Contas → Suspender contas` |
| 32 | Parametrização individualizada (notas, avisos, biblioteca) | ✅ | Categorias + cohorts + permissões granulares por contexto |
| 33 | Aluno em uma ou mais turmas | ✅ | Cohorts e groups nativos |
| 35 | Matrícula única por aluno | 🛠 | SIS é fonte de verdade da identidade — `auth_sisrj` impõe unicidade |
| 37 | Acesso para Alunos, Gestores, Professores, Diretores, Funcionários | ✅ + ⚙️ | Roles customizados além dos padrão (criar `gestor`, `diretor`, `funcionario` em `Administração → Usuários → Permissões`) |
| 40 | Atualização de dados em tempo real | 🛠 | Webhooks IN/OUT entre SIS e Moodle. Backup: reconciliação periódica via `\local_sisrj\task\sync` |
| 41 | Documentação em português do Brasil | ✅ | Pacote de idioma `pt_br` nativo |
| 42 | Vídeo aula sem cobrança por tempo | ⚙️ | Decisão de contrato — usar CDN com preço por GB transferido, não por minuto |
| 43 | Tradutor PT/EN/ES | ✅ | Pacotes `pt_br`, `en`, `es` + menu de idioma (já configurado no script) |
| 44 | Bancos dedicados por serviço | ☁️ | Postgres separado para Moodle, SIS e Auditoria |
| 45 | Perfis de acesso por tipo de usuário | ✅ | Sistema de roles do Moodle |
| 46 | Geração e controle de login/senha | ✅ + 🛠 | `auth_manual` para usuários locais; `auth_sisrj` para SSO |
| 47 | Leitura de QR Code | 🔌 | Plugin `mod_attendance` + extensão QR (ou `local_qrresource`) |
| 48 | Videoconferência com breakout rooms | 🔌 | Plugin `mod_bigbluebuttonbn` (free, breakouts nativos) ou `mod_zoom` |
| 51 | Plataforma de cursos livres com certificação no currículo | 🔌 + 🛠 | `mod_customcert` para emissão. Histórico no perfil via `local_sisrj` |
| 52 | Controle de acesso via QR Code | 🔌 | `mod_attendance` com QR de sessão |
| 53 | Plataforma de eventos/seminários com certificados digitais | 🔌 | `mod_facetoface` + `mod_customcert` |
| 54 | Formações com certificados digitais | 🔌 | `mod_customcert` |
| 55 | Compatível com Edge, Firefox, Chrome | ✅ | Suportado nativamente. Testes em Behat + manuais |
| 56 | Layout responsivo (tablet/smartphone) | ✅ | `theme_edukkare` (child de Boost) responsivo |

## 2. Requisitos ESSENCIAIS — App móvel

| # | Requisito | Status | Ação técnica |
|---|---|---|---|
| 1 | iOS 11+ e Android 5.1+ | 🛠 | Fork do Moodle App (Ionic). Build alvo definido no `config.xml` |
| 2 | 3G/4G/5G e Wi-Fi | ✅ | Comportamento nativo do app + suporte offline para conteúdo SCORM |

## 3. Segurança (item 4.5 do TER)

| Requisito | Status | Ação técnica |
|---|---|---|
| MFA por e-mail institucional | 🔌 | Plugin oficial `tool_mfa` + factor `email`. Fallback `factor_totp` |
| Senha 12-20 chars, 3/4 critérios | ⚙️ | Política configurada via `apply-edukkare-defaults.sh` (minpasswordlength=12, lower/upper/digit/nonalpha=1) |
| Termo de Compromisso, Sigilo e Confidencialidade | 🔌 + 📋 | `tool_policy` com versões publicadas + aceite obrigatório no primeiro login |
| SLA Sev1 15min/2h, Sev2 1h/12h, Sev3 4h/24h, 24x7 | 📋 + ☁️ | Equipe de plantão + Statuspage + alerting (PagerDuty/Opsgenie) + monitoramento contínuo |

---

## 4. Requisitos DESEJÁVEIS

| # | Requisito | Status | Ação técnica |
|---|---|---|---|
| 04 | Servidores de vídeo próprios | ☁️ | Opcional. Se atender: AWS MediaConvert + S3 + CloudFront com HLS. Investimento adicional |
| 07 | White Label | 🛠 ✅ | `theme_edukkare` já entrega isso |
| 08 | Suporte nativo a FTP | ☁️ | Habilitar SFTP no bucket S3 ou container dedicado para ingestão de mídia |
| 21 | Monitoramento centralizado | ☁️ | Grafana + Prometheus + Loki para logs. Atende SLA do TER |
| 22 | Fórmulas de cálculo (média, frequência mínima) | ✅ | Gradebook do Moodle suporta fórmulas livres |
| 23 | Testes de performance/stress | 📋 | k6 ou Artillery em pipeline pré-go-live |
| 24 | Microsserviços | ☁️ + 📋 | **Argumentar:** modular via plugins; serviços auxiliares (vídeo, IA, busca) são microsserviços separados em K8s |
| 26 | BD de leitura dedicado | ☁️ | Postgres read replica para queries pesadas (relatórios) |
| 34 | Permitir e-mail pessoal | ⚙️ | `allowemailaddresses` vazio + remover restrição de domínio |
| 36 | Apenas exclusão lógica de dados pessoais | ✅ | Comportamento default da Privacy API (soft delete) |
| 38 | Temas customizáveis por usuário | ⚙️ + 🛠 | `allowuserthemes=1` (já desativado por orientação institucional). Manter como `0` para padronização visual |
| 39 | Envio tipo "AirDrop" | 🛠 | Custom: file picker peer-to-peer ou compartilhamento via QR Code (`local_sisrj`) |
| 49 | Exportar PDF/XLS/DOC/PPT/CSV/XML | ✅ + 🔌 | PDF/CSV/XLS nativos. DOC/PPT: plugin `dataformat_html` + biblioteca externa |
| 50 | Ferramentas automáticas de manutenção | ⚙️ | Cron tasks do core + jobs custom em `\local_sisrj\task\` |
| App 3 | App grátis nas lojas | 🛠 | Publicação Apple/Google Play sob conta EDUKKARE |
| App 4 | Vídeos no app | ✅ | Suporte nativo do Moodle App |
| App 5 | "AirDrop" no app | 🛠 | Mesma feature do item 39 portada para app |

---

## 5. Plugins de terceiros a INSTALAR

Listados em ordem de prioridade de implantação. Todos disponíveis no [Moodle Plugins Directory](https://moodle.org/plugins) sob GPL.

```
admin/cli/install_plugin.php   (Moodle 5.x permite instalação CLI)
```

| Plugin | Componente | Atende item | Versão Moodle |
|---|---|---|---|
| Multi-factor authentication | `tool_mfa` | Seg. 4.5.1.1 | 5.0+ |
| BigBlueButton | `mod_bigbluebuttonbn` | 48 | 5.0+ |
| Custom Certificate | `mod_customcert` | 51, 53, 54 | 5.0+ |
| Face-to-Face | `mod_facetoface` | 29, 53 | 5.0+ |
| Attendance | `mod_attendance` | 47, 52 | 5.0+ |
| Site Policy | `tool_policy` | 27, 4.5.1.3 | core (já vem) |
| Helpdesk / Tickets | `local_helpdesk` (ou Zendesk via API) | 15 | varia |
| OpenAI provider | `aiprovider_openai` | 09 | 4.5+ (core) |

## 6. Plugins próprios a DESENVOLVER

| Plugin | Tipo | Responsabilidade | Status |
|---|---|---|---|
| `theme_edukkare` | theme | White-label, paleta indigo+stone, tipografia Inter | ✅ Pronto MVP |
| `auth_sisrj` | auth | SSO via OAuth2/JWT com o SIS, sincronia de perfil | 📋 A iniciar |
| `enrol_sisrj` | enrol | Provisionamento de matrícula via webhook do SIS | 📋 A iniciar |
| `local_sisrj` | local | Engine de sync, endpoints REST, scheduled tasks, listeners de eventos | 📋 A iniciar |
| `tool_sisrj` | tool | UI admin da integração (logs, retry, status) | 📋 A iniciar |

## 7. Infraestrutura mínima

```
┌─────────────────────────────────────────────────────────┐
│ Cloud Brasil (AWS sa-east-1 ou Azure Brazil South)      │
│                                                          │
│   ALB ──▶ EKS/AKS                                       │
│             ├─ Moodle pods (auto-scaling)               │
│             ├─ SIS pods                                  │
│             ├─ Worker pods (cron, sync)                 │
│             └─ Redis (sessions + cache)                 │
│                                                          │
│   RDS Postgres                                          │
│             ├─ moodle (primary + read replica)          │
│             ├─ sis (primary + read replica)             │
│             └─ audit                                    │
│                                                          │
│   S3 ──▶ CloudFront                                     │
│             └─ media + moodledata                       │
│                                                          │
│   CloudWatch + Grafana + Loki + PagerDuty               │
└─────────────────────────────────────────────────────────┘
```

## 8. Próximos passos imediatos (sequência sugerida)

1. **Finalizar `theme_edukkare`** — branding completo (logos vetoriais, tela de login, dashboard limpo)
2. **Instalar plugins de terceiros** essenciais: `tool_mfa`, `mod_bigbluebuttonbn`, `mod_customcert`, `mod_facetoface`, `mod_attendance`, `tool_policy`
3. **Iniciar `local_sisrj`** com scaffolding mínimo: `version.php`, `db/services.php`, esqueleto de webhook receiver e scheduled task
4. **Definir contrato de webhooks SIS ↔ Moodle** (eventos, payload, autenticação JWT, retry policy)
5. **Subir staging** em AWS sa-east-1 com Postgres dedicado e domínio `staging.edukkare.com.br` para validação contínua
6. **Forkar o Moodle App** e configurar build pipeline (Bitrise ou GitHub Actions) com identidade visual Edukkare
7. **Gerar a matriz de aderência ao TER** (este documento) como anexo da proposta comercial

---

*Última atualização: 2026-05-10. Documento vivo — atualize sempre que um item mudar de status.*
