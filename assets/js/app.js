const sidebarToggle = document.getElementById('sidebarToggle');
const profileTrigger = document.getElementById('profileTrigger');
const profileDropdown = document.getElementById('profileDropdown');
const profile = profileTrigger ? profileTrigger.closest('.profile') : null;

sidebarToggle?.addEventListener('click', () => {
  document.getElementById('appShell')?.classList.toggle('sidebar-collapsed');
});

profileTrigger?.addEventListener('click', (e) => {
  e.stopPropagation();
  profile.classList.toggle('is-open');
});

document.addEventListener('click', (e) => {
  if (profile && !e.target.closest('.profile')) {
      profile.classList.remove('is-open');
  }
});

document.addEventListener('keydown', (e) => {
  if (e.key === 'Escape' && profile) {
      profile.classList.remove('is-open');
  }
});

document.querySelectorAll('.nav-link').forEach(link => {
  link.addEventListener('mouseenter', () => {
      link.querySelector('.nav-icon')?.classList.add('nav-icon-hover');
  });
  link.addEventListener('mouseleave', () => {
      link.querySelector('.nav-icon')?.classList.remove('nav-icon-hover');
  });
});
