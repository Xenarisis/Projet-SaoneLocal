document.addEventListener('DOMContentLoaded', () => {
            const targets = document.querySelectorAll('.magic-underline-block');
            
            // Étape 1 : Calculer les longueurs silencieusement
            const paths = document.querySelectorAll('.branch-anim path');
            paths.forEach(path => {
                const length = path.getTotalLength();
                path.style.setProperty('--path-length', length + 5);
            });

            // Étape 2 : Ajouter la classe .is-ready pour activer les transitions CSS
            // On utilise requestAnimationFrame pour être sûr que le navigateur a digéré les nouvelles variables CSS
            requestAnimationFrame(() => {
                requestAnimationFrame(() => {
                    targets.forEach(t => t.classList.add('is-ready'));
                    
                    // Étape 3 : Démarrer l'observeur d'intersection
                    const io = new IntersectionObserver((entries) => {
                        entries.forEach(e => {
                            if (e.isIntersecting) {
                                e.target.classList.add('is-visible');
                            } else {
                                e.target.classList.remove('is-visible');
                            }
                        });
                    }, { threshold: 0.1 });
                    
                    targets.forEach(t => io.observe(t));
                });
            });
        });