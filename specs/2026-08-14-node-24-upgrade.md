# Upgrade api naar Node.js 24 en osls

`2026-08-14` · Ramiro Hammen

## Waarom

- De Lambda-runtime `nodejs20.x` is sinds 30 april 2026 deprecated; AWS blokkeert nieuwe functions per 1 februari 2027 en function-updates per 3 maart 2027.
- Node.js 24 is de huidige actieve LTS; de Lambda-runtime `nodejs24.x` wordt ondersteund tot april 2028.
- Serverless Framework v3 is unmaintained en kent `nodejs24.x` niet; met `configValidationMode: error` faalt elke deploy op die runtime.
- De [osls-fork](https://github.com/oss-serverless/serverless) (MIT, actief onderhouden v3-lijn) ondersteunt `nodejs24.x` en levert dezelfde `serverless`/`sls`-CLI, dus bestaande deploy-workflows blijven werken.
- Officiële Serverless v4 is afgewezen: vereist een Serverless-account plus access key in de CI van elk project en heeft een commerciële licentie.

## Scope

- **Wel:** `runtime: nodejs24.x` in `api/serverless.example.yml`; Node 24 in `.github/workflows/ci.yml` en `api/deploy.example.yml`; `engines.node: 24`; `serverless ^3.40.0` vervangen door `osls ^3.77.0` (incl. `yarn.lock`); changelog-entry.
- **Niet:** downstream-projecten bijwerken — die stappen zelf over wanneer ze hun `SERVICE_VERSION` en gekopieerde config bumpen; `nova-plugin/` en `wordpress-plugin/`; bump van `@aws-sdk/client-dynamodb`; code-wijzigingen in `api.js`/`origin.js`.

## Acceptatiecriteria

1. `api/serverless.example.yml` gebruikt `runtime: nodejs24.x` en osls accepteert de config met `configValidationMode: error` (geen validatiefouten bij packagen).
2. `api/package.json` heeft `engines.node: "24"`, devDependency `osls ^3.77.0` en geen `serverless` meer; `yarn.lock` is bijgewerkt.
3. CI (Prettier-job) draait op Node 24.x en is groen.
4. Een testdeploy met osls naar de staging-stage van [week-van-de-circulaire-economie](https://github.com/grrr-amsterdam/week-van-de-circulaire-economie) slaagt; het api-endpoint slaat een redirect op en het origin-endpoint voert die uit.
5. De versie is `3.0.0`: major volgens semver, omdat consumers hun gekopieerde `serverless.yml` (runtime-regel) en deploy-workflow (node-version) moeten aanpassen en `yarn install` op Node 20 faalt door de engines-bump.
6. `CHANGELOG.md` bevat een `v3.0.0`-entry die beschrijft wat projecten bij het overstappen moeten aanpassen.
