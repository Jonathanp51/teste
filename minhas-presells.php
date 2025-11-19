<?php
require_once 'includes/config.php';
requireLogin();

$db = Database::getInstance();

// Buscar estatísticas
$stats = [
    'total_presells' => $db->query("SELECT COUNT(*) as count FROM presells")->fetch()['count'],
    'published_presells' => $db->query("SELECT COUNT(*) as count FROM presells WHERE status = 'published'")->fetch()['count'],
    'total_views' => $db->query("SELECT SUM(views) as total FROM stats")->fetch()['total'] ?? 0,
    'total_clicks' => $db->query("SELECT SUM(clicks) as total FROM stats")->fetch()['total'] ?? 0
];

// Últimos presells
$recent_presells = $db->query("
    SELECT p.*, 
           (SELECT SUM(views) FROM stats WHERE presell_id = p.id) as total_views,
           (SELECT SUM(clicks) FROM stats WHERE presell_id = p.id) as total_clicks
    FROM presells p 
    ORDER BY created_at DESC 
    LIMIT 5
")->fetchAll();

// Gráfico de visualizações dos últimos 7 dias
$views_data = $db->query("
    SELECT DATE(created_at) as date, SUM(views) as views 
    FROM stats 
    WHERE created_at >= DATE_SUB(CURDATE(), INTERVAL 7 DAY)
    GROUP BY DATE(created_at)
    ORDER BY date ASC
")->fetchAll();

// Preparar dados para o gráfico
$chart_labels = [];
$chart_views = [];

foreach ($views_data as $row) {
    $chart_labels[] = date('d/m', strtotime($row['date']));
    $chart_views[] = $row['views'];
}

include 'templates/header.php';
?>

<div class="container mx-auto px-4 py-8">
    <h1 class="text-2xl font-bold text-gray-800 mb-6">Dashboard</h1>
    
    <!-- Cards de Estatísticas -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-indigo-100 text-indigo-600">
                    <i class="fas fa-file-alt text-xl"></i>
                </div>
                <div class="ml-4">
                    <h3 class="text-gray-500 text-sm font-medium">Total de Presells</h3>
                    <p class="text-2xl font-semibold text-gray-800"><?= $stats['total_presells'] ?></p>
                </div>
            </div>
        </div>
        
        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-green-100 text-green-600">
                    <i class="fas fa-check-circle text-xl"></i>
                </div>
                <div class="ml-4">
                    <h3 class="text-gray-500 text-sm font-medium">Publicados</h3>
                    <p class="text-2xl font-semibold text-gray-800"><?= $stats['published_presells'] ?></p>
                </div>
            </div>
        </div>
        
        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-blue-100 text-blue-600">
                    <i class="fas fa-eye text-xl"></i>
                </div>
                <div class="ml-4">
                    <h3 class="text-gray-500 text-sm font-medium">Visualizações</h3>
                    <p class="text-2xl font-semibold text-gray-800"><?= number_format($stats['total_views']) ?></p>
                </div>
            </div>
        </div>
        
        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-yellow-100 text-yellow-600">
                    <i class="fas fa-mouse-pointer text-xl"></i>
                </div>
                <div class="ml-4">
                    <h3 class="text-gray-500 text-sm font-medium">Cliques</h3>
                    <p class="text-2xl font-semibold text-gray-800"><?= number_format($stats['total_clicks']) ?></p>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Gráfico de Visualizações -->
    <div class="bg-white rounded-lg shadow p-6 mb-8">
        <div class="flex justify-between items-center mb-4">
            <h2 class="text-lg font-semibold text-gray-800">Visualizações dos Últimos 7 Dias</h2>
        </div>
        <canvas id="viewsChart" height="100"></canvas>
    </div>
    
    <!-- Últimos Presells -->
    <div class="bg-white rounded-lg shadow overflow-hidden">
        <div class="p-6">
            <div class="flex justify-between items-center mb-4">
                <h2 class="text-lg font-semibold text-gray-800">Últimos Presells</h2>
                <a href="presells/create.php" class="bg-indigo-600 text-white px-4 py-2 rounded-md hover:bg-indigo-700 transition duration-150">
                    <i class="fas fa-plus mr-2"></i>Novo Presell
                </a>
            </div>
            
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Título</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Visualizações</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Cliques</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Data</th>
                            <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Ações</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        <?php foreach ($recent_presells as $presell): ?>
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-medium text-gray-900"><?= htmlspecialchars($presell['title']) ?></div>
                                <div class="text-sm text-gray-500">/<?= htmlspecialchars($presell['slug']) ?></div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                    <?= $presell['status'] === 'published' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' ?>">
                                    <?= $presell['status'] === 'published' ? 'Publicado' : 'Rascunho' ?>
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                <?= number_format($presell['total_views'] ?? 0) ?>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                <?= number_format($presell['total_clicks'] ?? 0) ?>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                <?= date('d/m/Y', strtotime($presell['created_at'])) ?>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                <a href="presells/edit.php?id=<?= $presell['id'] ?>" class="text-indigo-600 hover:text-indigo-900 mr-3">Editar</a>
                                <a href="presells/delete.php?id=<?= $presell['id'] ?>" class="text-red-600 hover:text-red-900" onclick="return confirm('Tem certeza que deseja excluir este presell?')">Excluir</a>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Gráfico de visualizações
    const ctx = document.getElementById('viewsChart').getContext('2d');
    const viewsChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: <?= json_encode($chart_labels) ?>,
            datasets: [{
                label: 'Visualizações',
                data: <?= json_encode($chart_views) ?>,
                borderColor: 'rgb(99, 102, 241)',
                tension: 0.4,
                fill: true,
                backgroundColor: 'rgba(99, 102, 241, 0.1)'
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    display: false
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        precision: 0
                    }
                }
            }
        }
    });
</script>

<?php include 'templates/footer.php'; ?>
