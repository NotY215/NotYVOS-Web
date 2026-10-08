document.addEventListener('DOMContentLoaded', () => {
  const page = document.querySelector('.roadmap-page');
  if (!page) return;

  // Keep every phase visible even if another site script adds reveal classes.
  document.querySelectorAll('.roadmap-phase').forEach((phase) => {
    phase.classList.add('visible');
    phase.style.removeProperty('opacity');
    phase.style.removeProperty('transform');
  });

  const current = page.dataset.roadmapCurrent || '17';
  const active = document.querySelector(`.roadmap-phase[data-phase="${CSS.escape(current)}"]`);
  if (active) {
    document.querySelectorAll('.roadmap-phase-active').forEach((item) => {
      if (item !== active) item.classList.remove('roadmap-phase-active');
    });
    active.classList.add('roadmap-phase-active');
  }

  // The roadmap is server-rendered. This script only verifies the visible
  // timeline and never replaces valid server HTML with an empty state.
  const timeline = document.querySelector('.roadmap-timeline');
  if (timeline && timeline.querySelectorAll('.roadmap-phase').length > 0) {
    timeline.setAttribute('data-rendered', 'true');
  }
});
