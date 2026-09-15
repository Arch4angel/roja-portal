(() => {
  'use strict';
  const section = document.getElementById('rp-comments');
  if (!section || section.dataset.initialized) return;
  const button = section.querySelector('.rp-comments-load');
  const status = section.querySelector('.rp-comments-status');
  const thread = document.getElementById('disqus_thread');
  if (!button || !status || !thread) return;
  const { shortname, identifier, url, title } = section.dataset;
  if (!/^[a-z0-9](?:[a-z0-9-]{0,61}[a-z0-9])?$/.test(shortname || '')
      || !/^joomla-article-[1-9][0-9]*$/.test(identifier || '')) return;
  let pageUrl;
  try { pageUrl = new URL(url); } catch { return; }
  if (!['http:', 'https:'].includes(pageUrl.protocol)) return;
  section.dataset.initialized = 'true';
  let loading = false;
  button.addEventListener('click', () => {
    if (loading) return;
    loading = true;
    button.disabled = true;
    status.textContent = 'Memuat komentar…';
    window.disqus_config = function () {
      this.page.url = pageUrl.href;
      this.page.identifier = identifier;
      this.page.title = title;
      this.callbacks = this.callbacks || {};
      this.callbacks.onReady = [() => {
        status.textContent = '';
        button.hidden = true;
      }];
    };
    const script = document.createElement('script');
    script.src = `https://${shortname}.disqus.com/embed.js`;
    script.async = true;
    script.setAttribute('data-timestamp', String(Date.now()));
    script.onerror = () => {
      loading = false;
      button.disabled = false;
      button.textContent = 'Coba lagi';
      status.textContent = 'Komentar belum dapat dimuat. Periksa koneksi atau pemblokir konten, lalu coba lagi.';
      script.remove();
    };
    script.onload = () => {
      button.hidden = true;
      status.textContent = '';
    };
    document.head.appendChild(script);
  });
})();
