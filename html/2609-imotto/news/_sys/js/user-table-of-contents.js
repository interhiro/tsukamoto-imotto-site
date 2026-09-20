/** ===========================================================
 * 、目次を作成するためのjs
=============================================================== */
// 初期コードで作成されるHTML例
/* ----------------------------------------------------
<ul>
  <li class="toc-h3">
    <a href="#section-0-0">みだし３</a>
  </li>
  <li class="toc-h4">
    <a href="#section-0-1">みだし４</a>
  </li>
  <li class="toc-h5">
    <a href="#section-0-2">みだし５</a>
  </li>
</ul>
---------------------------------------------------- */

document.addEventListener('DOMContentLoaded', () => {
    // --- 【設定項目】ここを書き換えるだけで調整できます ---
    const CONFIG = {
        tocTargetId: '#toc', // 目次を出力する場所
        contentClass: '.js-toc-content', // 本文（見出しを探す範囲）のクラス名
        targetHeadings: 'h3, h4, h5', // 目次にする見出しのレベル
        idPrefix: 'section', // 自動付与するIDの接頭語
    };
    // --------------------------------------------------

    const tocContainer = document.querySelector(CONFIG.tocTargetId);
    if (!tocContainer) return; // 指定した目次コンテナがない場合は何もしない

    const contentAreas = document.querySelectorAll(CONFIG.contentClass);
    const tocList = document.createElement('ul');
    tocList.className = 'list_toc';

    contentAreas.forEach((content, areaIndex) => {
        const headings = content.querySelectorAll(CONFIG.targetHeadings);

        headings.forEach((heading, hIndex) => {
            // IDがなければ自動付与（一意になるようエリア番号と見出し番号を組み合わせる）
            if (!heading.id) {
                heading.id = `${CONFIG.idPrefix}-${areaIndex}-${hIndex}`;
            }

            const li = document.createElement('li');

            // CSSでデザインしやすいように、見出しレベルに応じたクラスを付与 (例: toc-h3)
            li.classList.add(`toc-${heading.tagName.toLowerCase()}`);

            const a = document.createElement('a');
            a.href = `#${heading.id}`;
            a.textContent = heading.textContent;

            li.appendChild(a);
            tocList.appendChild(li);
        });
    });

    tocContainer.appendChild(tocList);
});

$(document).ready(function() {
    if ($('#toc').is(':empty') || $('.list_toc').is(':empty')) {
        $('.toc_content').hide();
    }
});