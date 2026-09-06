(() => {
    const search = document.querySelector('.expanding-search');
    if (!search) return;

    const input = search.querySelector('.search-input');
    const button = search.querySelector('.search-circle');
    const searchableCards = [...document.querySelectorAll('.change-card, .article-card, .topic-grid > article')];

    const normalize = (value) => value
        .normalize('NFD')
        .replace(/[\u0300-\u036f]/g, '')
        .toLowerCase()
        .trim();

    const filterCards = () => {
        const keyword = normalize(input.value);
        searchableCards.forEach((card) => {
            card.hidden = keyword !== '' && !normalize(card.textContent).includes(keyword);
        });
    };

    const openSearch = () => {
        search.classList.add('is-open');
        button.setAttribute('aria-expanded', 'true');
        button.setAttribute('aria-label', 'Tìm kiếm');
        input.focus();
    };

    const closeSearch = () => {
        search.classList.remove('is-open');
        button.setAttribute('aria-expanded', 'false');
        button.setAttribute('aria-label', 'Mở tìm kiếm');
    };

    search.addEventListener('submit', (event) => {
        event.preventDefault();
        if (!search.classList.contains('is-open')) {
            openSearch();
            return;
        }
        filterCards();
    });

    input.addEventListener('input', filterCards);
    input.addEventListener('keydown', (event) => {
        if (event.key === 'Escape') {
            input.value = '';
            filterCards();
            closeSearch();
            button.focus();
        }
    });

    document.addEventListener('click', (event) => {
        if (!search.contains(event.target) && input.value.trim() === '') closeSearch();
    });
})();

(() => {
    const button = document.querySelector('.mobile-menu');
    const navigation = document.querySelector('#primary-navigation');
    if (!button || !navigation) return;

    const closeMenu = () => {
        navigation.classList.remove('is-open');
        button.classList.remove('is-open');
        button.setAttribute('aria-expanded', 'false');
        button.setAttribute('aria-label', 'Mở menu');
    };

    button.addEventListener('click', () => {
        const willOpen = !navigation.classList.contains('is-open');
        navigation.classList.toggle('is-open', willOpen);
        button.classList.toggle('is-open', willOpen);
        button.setAttribute('aria-expanded', String(willOpen));
        button.setAttribute('aria-label', willOpen ? 'Đóng menu' : 'Mở menu');
    });

    navigation.addEventListener('click', (event) => {
        if (event.target.closest('a')) closeMenu();
    });

    document.addEventListener('click', (event) => {
        if (!navigation.contains(event.target) && !button.contains(event.target)) closeMenu();
    });

    window.addEventListener('resize', () => {
        if (window.innerWidth > 1000) closeMenu();
    });
})();
