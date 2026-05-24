(() => {
  // =====================================
  // ハンバーガー / ドロワー開閉
  // =====================================
  const hamburger = document.querySelector(".js-hamburger");
  const drawer = document.querySelector(".js-drawer");

  if (hamburger && drawer) {
    hamburger.addEventListener("click", () => {
      document.body.classList.toggle("is-drawer-open");
      hamburger.classList.toggle("is-open");
      drawer.classList.toggle("is-open");
    });

    const drawerSearch = drawer.querySelector(".p-header__search--drawer");
    if (drawerSearch) {
      drawerSearch.addEventListener("click", () => {
        document.body.classList.remove("is-drawer-open");
        hamburger.classList.remove("is-open");
        drawer.classList.remove("is-open");
      });
    }

    drawer.addEventListener("click", (e) => {
      if (e.target === drawer) {
        document.body.classList.remove("is-drawer-open");
        hamburger.classList.remove("is-open");
        drawer.classList.remove("is-open");
      }
    });
  }

  // =====================================
  // スクロール時ヘッダー縮小
  // =====================================
  window.addEventListener(
    "scroll",
    () => {
      const isScrolled = window.scrollY > 50;
      document.body.classList.toggle("is-scrolled", isScrolled);
    },
    { passive: true },
  );

  // =====================================
  // ピックアップカルーセル（front-page）
  // =====================================
  if (document.querySelector(".p-pickup__swiper")) {
    const wrapper = document.querySelector(".p-pickup__swiper .swiper-wrapper");
    const originalSlides = wrapper.querySelectorAll(".swiper-slide");
    const slideCount = originalSlides.length;

    if (slideCount >= 3 && slideCount < 6) {
      originalSlides.forEach((slide) => {
        wrapper.appendChild(slide.cloneNode(true));
      });
    }

    if (slideCount > 1) {
      new Swiper(".p-pickup__swiper", {
        slidesPerView: "auto",
        centeredSlides: true,
        spaceBetween: 16,
        loop: slideCount >= 3,

        navigation: {
          nextEl: ".p-pickup__next",
          prevEl: ".p-pickup__prev",
        },

        breakpoints: {
          500: { spaceBetween: 25 },
          600: { spaceBetween: 35 },
          700: { spaceBetween: 45 },
          800: { spaceBetween: 55 },
          900: { spaceBetween: 65 },
        },
      });
    }
  }

  // =====================================
  // よく読まれている記事カルーセル
  // =====================================
  if (document.querySelector(".p-popular__swiper")) {
    new Swiper(".p-popular__swiper", {
      slidesPerView: "auto",
      spaceBetween: 16,

      navigation: {
        nextEl: ".p-popular__next",
        prevEl: ".p-popular__prev",
        disabledClass: "is-disabled",
      },

      scrollbar: {
        el: ".p-popular__scrollbar",
        draggable: true,
      },

      breakpoints: {
        500: { spaceBetween: 32 },
      },
    });
  }

  // =====================================
  // 関連記事カルーセル（single / tag）
  // =====================================
  if (document.querySelector(".p-related__swiper")) {
    new Swiper(".p-related__swiper", {
      slidesPerView: "auto",
      spaceBetween: 16,

      navigation: {
        nextEl: ".p-related__next",
        prevEl: ".p-related__prev",
        disabledClass: "is-disabled",
      },

      scrollbar: {
        el: ".p-related__scrollbar",
        draggable: true,
      },

      breakpoints: {
        500: { spaceBetween: 32 },
      },
    });
  }

  // =====================================
  // 記事一覧（フィルタ・ソート・ページネーション）
  // =====================================

  // --- 要素取得・状態 ---
  const archiveTabs = document.querySelectorAll(".p-archive__tab");
  const archiveSorts = document.querySelectorAll(".p-archive__sort-item");
  const archiveBody = document.querySelector(".p-archive__body");
  const archiveCards = document.querySelectorAll(".p-archive__list .c-card");
  const archivePagination = document.querySelector(
    "[data-js-pagination] ul.page-numbers",
  );
  const ARCHIVE_PER_PAGE = 6;

  let currentCategory = "all";
  let currentSort = "date";
  let currentPage = 1;

  const isJsArchive =
    archiveTabs.length > 0 &&
    archiveTabs[0].querySelector("a")?.dataset.category;

  if (isJsArchive) {
    // 初期アクティブタブから currentCategory を取得（/category/tips/ 等で初期表示する用）
    const initialActiveTab = document.querySelector(
      ".p-archive__tab.is-active",
    );
    if (initialActiveTab) {
      currentCategory =
        initialActiveTab.querySelector("a")?.dataset.category || "all";
    }

    applyArchiveFilterSort();

    // --- フィルタ（カテゴリータブのクリック）---
    archiveTabs.forEach((tab) => {
      tab.addEventListener("click", (e) => {
        e.preventDefault();
        const link = tab.querySelector("a");
        const category = link.dataset.category;
        if (!category) return;

        currentCategory = category;
        currentPage = 1;

        archiveTabs.forEach((t) => t.classList.remove("is-active"));
        tab.classList.add("is-active");

        ["all", "latest", "tips", "interview", "news"].forEach((c) => {
          archiveBody.classList.remove(`p-archive__body--${c}`);
        });
        archiveBody.classList.add(`p-archive__body--${category}`);

        applyArchiveFilterSort();
      });
    });

    // --- ソート（新着順 / 人気順のクリック）---
    archiveSorts.forEach((item) => {
      item.addEventListener("click", (e) => {
        e.preventDefault();
        const link = item.querySelector("a");
        const sort = link.dataset.sort;
        if (!sort) return;

        currentSort = sort;
        currentPage = 1;

        archiveSorts.forEach((i) => i.classList.remove("is-active"));
        item.classList.add("is-active");

        applyArchiveFilterSort();
      });
    });
  }

  // --- 描画（フィルタ・ソートの結果反映 + 表示件数制御）---
  function applyArchiveFilterSort() {
    let visible = [...archiveCards].filter((card) => {
      return (
        currentCategory === "all" || card.dataset.category === currentCategory
      );
    });

    visible.sort((a, b) => {
      const key = currentSort === "views" ? "views" : "date";
      return parseInt(b.dataset[key], 10) - parseInt(a.dataset[key], 10);
    });

    const parent = archiveCards[0]?.parentElement;
    if (!parent) return;

    archiveCards.forEach((card) => {
      card.style.display = "none";
    });

    let toShow;
    if (archivePagination) {
      const totalPages = Math.ceil(visible.length / ARCHIVE_PER_PAGE);
      if (currentPage > totalPages && totalPages > 0) currentPage = totalPages;

      const startIdx = (currentPage - 1) * ARCHIVE_PER_PAGE;
      const endIdx = startIdx + ARCHIVE_PER_PAGE;
      toShow = visible.slice(startIdx, endIdx);

      renderArchivePagination(totalPages);
    } else {
      toShow = visible.slice(0, ARCHIVE_PER_PAGE);
    }

    const fragment = document.createDocumentFragment();
    toShow.forEach((card) => {
      card.style.display = "";
      fragment.appendChild(card);
    });
    parent.appendChild(fragment);

    const emptyMessage = parent.querySelector(".p-archive__empty");
    if (emptyMessage) {
      emptyMessage.hidden = toShow.length > 0;
    }
  }

  // --- ページネーション（UI生成）---
  function renderArchivePagination(totalPages) {
    if (!archivePagination) return;
    if (totalPages <= 1) {
      archivePagination.innerHTML = "";
      return;
    }

    let html = "";

    if (currentPage > 1) {
      html += `<li><a class="prev page-numbers" href="#" data-page="${currentPage - 1}" aria-label="前のページへ"></a></li>`;
    }

    for (let i = 1; i <= totalPages; i++) {
      html +=
        i === currentPage
          ? `<li><span class="page-numbers current" aria-current="page">${i}</span></li>`
          : `<li><a class="page-numbers" href="#" data-page="${i}">${i}</a></li>`;
    }

    if (currentPage < totalPages) {
      html += `<li><a class="next page-numbers" href="#" data-page="${currentPage + 1}" aria-label="次のページへ"></a></li>`;
    }

    archivePagination.innerHTML = html;
  }

  // --- ページネーション（クリック処理、初回1回だけ登録）---
  if (archivePagination) {
    archivePagination.addEventListener("click", (e) => {
      const link = e.target.closest("a[data-page]");
      if (!link) return;
      e.preventDefault();
      currentPage = parseInt(link.dataset.page, 10);
      applyArchiveFilterSort();
      archiveBody.scrollIntoView({ behavior: "smooth", block: "start" });
    });
  }

  // =====================================
  // 続きを読むボタン（single）
  // =====================================
  const readMoreBtn = document.querySelector(".js-read-more");
  const moreBody = document.querySelector(".js-more-body");

  if (readMoreBtn && moreBody) {
    readMoreBtn.addEventListener("click", () => {
      moreBody.hidden = false;
      readMoreBtn.hidden = true;
    });
  }

  // =====================================
  // 目次から隠し本文へジャンプ（single）
  // =====================================
  const tocLinks = document.querySelectorAll(".p-single__toc a");
  if (tocLinks.length && moreBody) {
    tocLinks.forEach((link) => {
      link.addEventListener("click", () => {
        const targetId = link.getAttribute("href");
        const targetEl = document.querySelector(targetId);

        if (targetEl && moreBody.contains(targetEl) && moreBody.hidden) {
          moreBody.hidden = false;
          if (readMoreBtn) readMoreBtn.hidden = true;
        }
      });
    });
  }
})();
