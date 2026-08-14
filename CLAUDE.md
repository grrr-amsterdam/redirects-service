# Redirects service — Claude Code instructies

Dit bestand geldt voor iedereen die Claude Code in deze repo gebruikt. Lees het van begin tot eind voordat je begint.

## Project-context

Een microservice die website-redirects beheert en uitvoert. CMS'en sturen redirects naar een API die ze opslaat in DynamoDB; een CloudFront-origin voert de redirects uit (301/307/308) wanneer de content-origin een 404 teruggeeft. De repo bevat drie componenten:

- `api/` — AWS Lambda (Node 20, plain JavaScript, geen framework) met twee endpoints: de API (schrijft redirects naar DynamoDB) en de origin (leest redirects en geeft een redirect-response). Deployment via Serverless Framework; projecten kopiëren `serverless.example.yml` en `deploy.example.yml` naar hun eigen repo.
- `nova-plugin/` — Laravel Nova-tool (PHP ≥ 8.0, `Grrr\Redirects\Nova`) die een redirects-resource toevoegt aan Nova en wijzigingen naar de API stuurt. **Wordt door geen enkel project gebruikt** (onderzocht in augustus 2026, zie [het rapport](https://claude.ai/code/artifact/7601d7c5-6463-454a-b70b-64c4091add4f)) en wordt waarschijnlijk in de toekomst verwijderd — steek hier geen werk in zonder overleg.
- `wordpress-plugin/` — bevat alleen een verwijzing: de WordPress-plugin wordt onderhouden in [grrr-amsterdam/wordpress-redirects-service-plugin](https://github.com/grrr-amsterdam/wordpress-redirects-service-plugin). Wijzigingen aan de WordPress-plugin horen dáár, niet in deze repo.
- Redirect-model: `from` (met leading én trailing slash), `to` (leading slash of volledige URL), `permanently` (default `false`; permanent = 308, tijdelijk = 307).

## Tooling en commando's

- Format: `npx prettier --write .` (root-config, inclusief `@prettier/plugin-php` voor PHP-bestanden)
- Format-check (zoals CI): in `api/` draait CI `npx prettier --check .`
- Statische analyse: `composer static-analysis` (PHPStan level 9; de config noemt ook `wordpress-plugin`, maar daar staat geen code)
- Dependencies: `yarn install` in `api/`; `composer install` in de root (vereist Nova-credentials voor nova.laravel.com)
- Er zijn geen geautomatiseerde tests; CI draait alleen Prettier en PHPStan

## Algemene regels

De Norday-teamstandaarden (coding patterns, git-workflow, spec-driven development), de MCP-servers (Context7, Sentry) en de `/norday-engineering:spec`-skill komen uit de `norday-engineering`-plugin en gelden hier automatisch. Installeer die plugin als dat nog niet is gebeurd: `/plugin marketplace add norday-agency/claude-plugins` en `/plugin install norday-engineering@norday-tools`.
