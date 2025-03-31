// Fonction pour formater les grands nombres
function formatNumber(num) {
    if (num >= 1e9) {
        return `$${(num / 1e9).toFixed(1)}B`;
    } else if (num >= 1e6) {
        return `$${(num / 1e6).toFixed(1)}M`;
    } else {
        return `$${num.toLocaleString()}`;
    }
}

// Fonction pour récupérer les données des crypto-monnaies
async function fetchCryptoData() {
    try {
        const response = await fetch('https://api.coingecko.com/api/v3/coins/markets?vs_currency=usd&order=market_cap_desc&per_page=10&sparkline=false');
        if (!response.ok) {
            throw new Error('Erreur réseau');
        }
        const data = await response.json();
        return data;
    } catch (error) {
        console.error('Erreur lors de la récupération des données:', error);
        return null;
    }
}

// Fonction pour mettre à jour le tableau
function updateTable(data) {
    if (!data) return;

    data.forEach(crypto => {
        const cryptoId = crypto.id;
        const priceElement = document.getElementById(`${cryptoId}-price`);
        const changeElement = document.getElementById(`${cryptoId}-change`);
        const marketCapElement = document.getElementById(`${cryptoId}-marketcap`);
        const volumeElement = document.getElementById(`${cryptoId}-volume`);

        if (priceElement) {
            priceElement.textContent = `$${crypto.current_price.toLocaleString(undefined, {minimumFractionDigits: 2, maximumFractionDigits: 2})}`;
        }

        if (changeElement) {
            const change = crypto.price_change_percentage_24h;
            changeElement.textContent = `${change >= 0 ? '+' : ''}${change.toFixed(2)}%`;
            changeElement.className = change >= 0 ? 'text-success' : 'text-danger';
        }

        if (marketCapElement) {
            marketCapElement.textContent = formatNumber(crypto.market_cap);
        }

        if (volumeElement) {
            volumeElement.textContent = formatNumber(crypto.total_volume);
        }
    });
}

// Fonction d'initialisation
async function initializeCryptoUpdates() {
    // Mise à jour initiale
    const initialData = await fetchCryptoData();
    updateTable(initialData);

    // Mise à jour toutes les 30 secondes
    setInterval(async () => {
        const newData = await fetchCryptoData();
        updateTable(newData);
    }, 30000);
}

// Démarrer les mises à jour quand le document est chargé
document.addEventListener('DOMContentLoaded', initializeCryptoUpdates); 