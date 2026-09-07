const progressBars = document.querySelectorAll('.kpi-split span');

progressBars.forEach(bar => {
  const target = parseFloat(bar.style.width);
  if (isNaN(target)) return;
  let current = 0;
  const duration = 800;
  const stepTime = 16;
  const steps = duration / stepTime;
  const increment = target / steps;
  bar.style.width = '0%';
  const timer = setInterval(() => {
    current += increment;
    if (current >= target) {
      bar.style.width = target + '%';
      clearInterval(timer);
    } else {
      bar.style.width = current + '%';
    }
  }, stepTime);
});