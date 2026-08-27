---
paths:
  - 'tests/Feature/**'
---

# Feature

## RealisationFactory creates its own Service — fix service_id when counting services
RealisationFactory has 'service_id' => Service::factory() by default, so creating realisations in a test silently inserts one service per realisation. When a test counts `services` in an Inertia page (e.g. Home), pass an explicit `['service_id' => $service->id]` or reuse a single created service, otherwise counts are inflated (3 services + 3 realisations = 6 services).
