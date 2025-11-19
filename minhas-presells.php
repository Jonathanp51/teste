<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Perfect Presell</title>
    
    <!-- 1. Dependências -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/lucide@latest"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script> <!-- Biblioteca de Gráficos -->
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">

    <style>
        body { font-family: 'Roboto', sans-serif; }
        ::-webkit-scrollbar { width: 8px; }
        ::-webkit-scrollbar-track { background: #111827; }
        ::-webkit-scrollbar-thumb { background: #374151; border-radius: 4px; }
    </style>
</head>
<body class="bg-gray-900 text-gray-100 overflow-hidden">

    <!-- CONTAINER PRINCIPAL -->
    <div class="flex h-screen w-full">
        
        <!-- 2. SIDEBAR (Menu Lateral) -->
        <aside class="w-64 bg-gray-950 border-r border-gray-800 flex flex-col shrink-0 transition-all duration-300">
            <!-- Logo -->
            <div class="p-6 flex items-center gap-3 border-b border-gray-800 h-20">
                <div class="w-10 h-10 bg-gradient-to-br from-green-600 to-green-800 rounded-lg flex items-center justify-center font-bold text-white shadow-lg shadow-green-900/50 text-xl">P</div>
                <div class="flex flex-col">
                    <span class="font-bold text-lg tracking-tight text-white leading-none">PERFECT</span>
                    <span class="font-bold text-sm text-green-500 tracking-widest leading-none">PRESELL</span>
                </div>
            </div>

            <!-- Navegação -->
            <nav class="flex-1 p-4 space-y-2 overflow-y-auto">
                <!-- Item Ativo -->
                <a href="#" class="flex items-center gap-3 px-4 py-3 rounded-lg bg-green-600 text-white shadow-lg shadow-green-900/50 transition-all group">
                    <i data-lucide="layout-dashboard" class="w-5 h-5"></i>
                    <span class="font-medium">Dashboard</span>
                </a>

                <a href="criar-presell.html" class="flex items-center gap-3 px-4 py-3 rounded-lg text-gray-400 hover:bg-gray-800 hover:text-white transition-all group">
                    <i data-lucide="plus-circle" class="w-5 h-5 group-hover:text-green-400 transition-colors"></i>
                    <span class="font-medium">Criar Nova</span>
                </a>

                <a href="minhas-presells.html" class="flex items-center gap-3 px-4 py-3 rounded-lg text-gray-400 hover:bg-gray-800 hover:text-white transition-all group">
                    <i data-lucide="list" class="w-5 h-5 group-hover:text-green-400 transition-colors"></i>
                    <span class="font-medium">Minhas Presells</span>
                </a>

                <a href="criar-ia.html" class="flex items-center gap-3 px-4 py-3 rounded-lg text-gray-400 hover:bg-gray-800 hover:text-white transition-all group">
                    <i data-lucide="bot" class="w-5 h-5 group-hover:text-green-400 transition-colors"></i>
                    <span class="font-medium">Presell com IA</span>
                </a>
            </nav>

            <!-- Footer Menu -->
            <div class="p-4 border-t border-gray-800">
                <a href="index.html" class="flex items-center gap-3 text-red-400 hover:text-red-300 hover:bg-red-900/20 transition-colors w-full p-2 rounded text-sm">
                    <i data-lucide="log-out" class="w-4 h-4"></i>
                    <span>Sair</span>
                </a>
            </div>
        </aside>

        <!-- 3. CONTEÚDO PRINCIPAL -->
        <main class="flex-1 flex flex-col min-w-0 bg-gray-900 relative">
            
            <!-- Top Header -->
            <header class="h-20 bg-gray-900/95 backdrop-blur border-b border-gray-800 flex items-center justify-between px-8 shrink-0 z-20">
                <div>
                    <h1 class="text-xl font-bold text-white">Visão Geral</h1>
                    <p class="text-gray-400 text-xs">Acompanhe o desempenho das suas páginas</p>
                </div>
                
                <div class="flex items-center gap-4">
                    <a href="criar-presell.html" class="flex items-center gap-2 bg-white text-gray-900 hover:bg-gray-200 px-4 py-2 rounded-lg font-bold transition-all shadow-lg text-sm">
                        <i data-lucide="plus" class="w-4 h-4"></i>
                        Nova Página
                    </a>
                </div>
            </header>

            <!-- Área de Scroll -->
            <div class="flex-1 overflow-y-auto p-8 pb-20">
                <div class="max-w-7xl mx-auto space-y-8">
                    
                    <!-- CARDS DE ESTATÍSTICAS -->
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                        
                        <!-- Card 1: Total Presells -->
                        <div class="bg-gray-800 border border-gray-700 rounded-xl p-6 shadow-lg">
                            <div class="flex items-center justify-between mb-4">
                                <div class="p-3 rounded-lg bg-indigo-500/10 text-indigo-400">
                                    <i data-lucide="file-text" class="w-6 h-6"></i>
                                </div>
                                <span class="text-xs font-medium text-indigo-400 bg-indigo-500/10 px-2 py-1 rounded">+2 hoje</span>
                            </div>
                            <h3 class="text-gray-400 text-sm font-medium">Total de Presells</h3>
                            <p class="text-3xl font-bold text-white mt-1">12</p>
                        </div>

                        <!-- Card 2: Publicados -->
                        <div class="bg-gray-800 border border-gray-700 rounded-xl p-6 shadow-lg">
                            <div class="flex items-center justify-between mb-4">
                                <div class="p-3 rounded-lg bg-green-500/10 text-green-400">
                                    <i data-lucide="check-circle" class="w-6 h-6"></i>
                                </div>
                                <span class="text-xs font-medium text-green-400 bg-green-500/10 px-2 py-1 rounded">Ativos</span>
                            </div>
                            <h3 class="text-gray-400 text-sm font-medium">Páginas Publicadas</h3>
                            <p class="text-3xl font-bold text-white mt-1">8</p>
                        </div>

                        <!-- Card 3: Visualizações -->
                        <div class="bg-gray-800 border border-gray-700 rounded-xl p-6 shadow-lg">
                            <div class="flex items-center justify-between mb-4">
                                <div class="p-3 rounded-lg bg-blue-500/10 text-blue-400">
                                    <i data-lucide="eye" class="w-6 h-6"></i>
                                </div>
                                <span class="text-xs font-medium text-blue-400 bg-blue-500/10 px-2 py-1 rounded">+12%</span>
                            </div>
                            <h3 class="text-gray-400 text-sm font-medium">Visualizações Totais</h3>
                            <p class="text-3xl font-bold text-white mt-1">24.5k</p>
                        </div>

                        <!-- Card 4: Cliques -->
                        <div class="bg-gray-800 border border-gray-700 rounded-xl p-6 shadow-lg">
                            <div class="flex items-center justify-between mb-4">
                                <div class="p-3 rounded-lg bg-yellow-500/10 text-yellow-400">
                                    <i data-lucide="mouse-pointer-2" class="w-6 h-6"></i>
                                </div>
                                <span class="text-xs font-medium text-yellow-400 bg-yellow-500/10 px-2 py-1 rounded">CTR 18%</span>
                            </div>
                            <h3 class="text-gray-400 text-sm font-medium">Cliques no Botão</h3>
                            <p class="text-3xl font-bold text-white mt-1">4.2k</p>
                        </div>
                    </div>

                    <!-- GRÁFICO -->
                    <div class="bg-gray-800 border border-gray-700 rounded-xl p-6 shadow-lg">
                        <div class="flex justify-between items-center mb-6">
                            <h2 class="text-lg font-bold text-white">Performance (Últimos 7 Dias)</h2>
                            <select class="bg-gray-900 border border-gray-700 text-gray-300 text-sm rounded-lg focus:ring-green-500 focus:border-green-500 block p-2">
                                <option>Visualizações</option>
                                <option>Cliques</option>
                            </select>
                        </div>
                        <!-- Altura fixa para o gráfico -->
                        <div class="h-80 w-full">
                            <canvas id="viewsChart"></canvas>
                        </div>
                    </div>

                    <!-- TABELA DE ÚLTIMAS PRESELLS -->
                    <div class="bg-gray-800 border border-gray-700 rounded-xl shadow-lg overflow-hidden">
                        <div class="p-6 border-b border-gray-700 flex justify-between items-center">
                            <h2 class="text-lg font-bold text-white">Últimas Páginas Criadas</h2>
                            <a href="minhas-presells.html" class="text-sm text-green-400 hover:text-green-300 font-medium">Ver todas -></a>
                        </div>
                        
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-700">
                                <thead class="bg-gray-900/50">
                                    <tr>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">Título / Slug</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">Status</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">Visualizações</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">Cliques</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">Data</th>
                                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-400 uppercase tracking-wider">Ações</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-gray-800 divide-y divide-gray-700">
                                    <!-- Item 1 -->
                                    <tr class="hover:bg-gray-750 transition-colors">
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm font-bold text-white">Método Seca Barriga</div>
                                            <div class="text-xs text-gray-500">/metodo-seca-barriga</div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-900/50 text-green-400 border border-green-700">
                                                Publicado
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-300">1,240</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-300">350</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">19/11/2023</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                            <a href="#" class="text-indigo-400 hover:text-indigo-300 mr-3"><i data-lucide="pencil" class="w-4 h-4 inline"></i></a>
                                            <a href="#" class="text-red-400 hover:text-red-300"><i data-lucide="trash-2" class="w-4 h-4 inline"></i></a>
                                        </td>
                                    </tr>
                                    
                                    <!-- Item 2 -->
                                    <tr class="hover:bg-gray-750 transition-colors">
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm font-bold text-white">Renda Extra com IA</div>
                                            <div class="text-xs text-gray-500">/renda-extra-ia</div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-900/50 text-yellow-400 border border-yellow-700">
                                                Rascunho
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-300">0</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-300">0</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">18/11/2023</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                            <a href="#" class="text-indigo-400 hover:text-indigo-300 mr-3"><i data-lucide="pencil" class="w-4 h-4 inline"></i></a>
                                            <a href="#" class="text-red-400 hover:text-red-300"><i data-lucide="trash-2" class="w-4 h-4 inline"></i></a>
                                        </td>
                                    </tr>

                                    <!-- Item 3 -->
                                    <tr class="hover:bg-gray-750 transition-colors">
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm font-bold text-white">App Espião</div>
                                            <div class="text-xs text-gray-500">/app-espiao-2024</div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-900/50 text-green-400 border border-green-700">
                                                Publicado
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-300">5,100</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-300">980</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">15/11/2023</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                            <a href="#" class="text-indigo-400 hover:text-indigo-300 mr-3"><i data-lucide="pencil" class="w-4 h-4 inline"></i></a>
                                            <a href="#" class="text-red-400 hover:text-red-300"><i data-lucide="trash-2" class="w-4 h-4 inline"></i></a>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                </div>
            </div>
        </main>
    </div>

    <!-- Script do Gráfico e Ícones -->
    <script>
        lucide.createIcons();

        // Configuração do Gráfico para Dark Mode
        const ctx = document.getElementById('viewsChart').getContext('2d');
        
        // Definir cores globais do gráfico para cinza claro
        Chart.defaults.color = '#9ca3af';
        Chart.defaults.borderColor = '#374151';

        const viewsChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: ['13/11', '14/11', '15/11', '16/11', '17/11', '18/11', 'Hoje'],
                datasets: [{
                    label: 'Visualizações',
                    data: [150, 230, 180, 320, 290, 450, 510],
                    borderColor: '#16a34a', // Verde (green-600)
                    backgroundColor: 'rgba(22, 163, 74, 0.1)', // Fundo verde transparente
                    borderWidth: 3,
                    tension: 0.4, // Curva suave
                    fill: true,
                    pointBackgroundColor: '#16a34a',
                    pointBorderColor: '#fff',
                    pointHoverBackgroundColor: '#fff',
                    pointHoverBorderColor: '#16a34a'
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false // Esconder legenda padrão
                    },
                    tooltip: {
                        backgroundColor: '#1f2937',
                        titleColor: '#fff',
                        bodyColor: '#fff',
                        borderColor: '#374151',
                        borderWidth: 1
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        grid: {
                            color: '#374151' // Linhas de grade escuras
                        }
                    },
                    x: {
                        grid: {
                            display: false // Remover grade vertical para visual mais limpo
                        }
                    }
                }
            }
        });
    </script>
</body>
</html>
