<?php
// --- LÓGICA PHP ORIGINAL (MANTIDA) ---
// Certifique-se que o caminho do config.php está correto no seu servidor
require_once '../includes/config.php'; 
requireLogin();

$errors = [];
$presell = [
    'title' => '',
    'slug' => '',
    'content' => '',
    'status' => 'draft'
];

// Simulação de SITE_URL caso não esteja definido no config (para evitar erros visuais)
if (!defined('SITE_URL')) define('SITE_URL', 'https://seusite.com');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Processar formulário
    $presell = array_merge($presell, $_POST);
    
    // Validação
    if (empty($presell['title'])) {
        $errors[] = 'O título é obrigatório';
    }
    
    if (empty($presell['slug'])) {
        $presell['slug'] = createSlug($presell['title']);
    } else {
        $presell['slug'] = createSlug($presell['slug']);
    }
    
    // Verificar se o slug já existe
    $db = Database::getInstance();
    $stmt = $db->prepare("SELECT id FROM presells WHERE slug = ?");
    $stmt->execute([$presell['slug']]);
    if ($stmt->fetch()) {
        $errors[] = 'Já existe um presell com este slug. Por favor, escolha outro.';
    }
    
    if (empty($errors)) {
        // Salvar no banco de dados
        $stmt = $db->prepare("
            INSERT INTO presells (title, slug, content, status, created_at, updated_at)
            VALUES (?, ?, ?, ?, NOW(), NOW())
        ");
        
        if ($stmt->execute([
            $presell['title'],
            $presell['slug'],
            $presell['content'],
            $presell['status']
        ])) {
            $presell_id = $db->lastInsertId();
            $_SESSION['success'] = 'Presell criado com sucesso!';
            // Redireciona para página de edição ou lista
            header("Location: minhas-presells.php"); 
            exit;
        } else {
            $errors[] = 'Erro ao salvar o presell. Tente novamente.';
        }
    }
}

// Função auxiliar de slug (caso não esteja no config)
function createSlug($text) {
    return strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $text)));
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nova Presell - Perfect Presell</title>
    
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/lucide@latest"></script>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
    <!-- CKEditor -->
    <script src="https://cdn.ckeditor.com/ckeditor5/30.0.0/classic/ckeditor.js"></script>

    <style>
        body { font-family: 'Roboto', sans-serif; }
        ::-webkit-scrollbar { width: 8px; }
        ::-webkit-scrollbar-track { background: #111827; }
        ::-webkit-scrollbar-thumb { background: #374151; border-radius: 4px; }
        
        /* Ajustes para o CKEditor no Dark Mode */
        .ck-editor__editable {
            min-height: 300px;
            background-color: #1f2937 !important; /* gray-800 */
            color: #e5e7eb !important; /* gray-200 */
        }
        .ck.ck-editor__main>.ck-editor__editable:not(.ck-focused) {
            border-color: #374151 !important;
        }
        .ck.ck-toolbar {
            background-color: #111827 !important; /* gray-900 */
            border-color: #374151 !important;
        }
        .ck.ck-button {
            color: #d1d5db !important;
        }
        .ck.ck-button:hover {
            background-color: #374151 !important;
        }
    </style>
</head>
<body class="bg-gray-900 text-gray-100 overflow-hidden">

    <div class="flex h-screen w-full">
        
        <!-- SIDEBAR (Mesma da Dashboard, com item ativo alterado) -->
        <aside class="w-64 bg-gray-950 border-r border-gray-800 flex flex-col shrink-0 transition-all duration-300">
            <div class="p-6 flex items-center gap-3 border-b border-gray-800 h-20">
                <div class="w-10 h-10 bg-gradient-to-br from-green-600 to-green-800 rounded-lg flex items-center justify-center font-bold text-white shadow-lg shadow-green-900/50 text-xl">P</div>
                <div class="flex flex-col">
                    <span class="font-bold text-lg tracking-tight text-white leading-none">PERFECT</span>
                    <span class="font-bold text-sm text-green-500 tracking-widest leading-none">PRESELL</span>
                </div>
            </div>

            <nav class="flex-1 p-4 space-y-2 overflow-y-auto">
                <a href="index.php" class="flex items-center gap-3 px-4 py-3 rounded-lg text-gray-400 hover:bg-gray-800 hover:text-white transition-all group">
                    <i data-lucide="layout-dashboard" class="w-5 h-5 group-hover:text-green-400 transition-colors"></i>
                    <span class="font-medium">Dashboard</span>
                </a>

                <!-- ITEM ATIVO AQUI -->
                <a href="#" class="flex items-center gap-3 px-4 py-3 rounded-lg bg-green-600 text-white shadow-lg shadow-green-900/50 transition-all group">
                    <i data-lucide="plus-circle" class="w-5 h-5"></i>
                    <span class="font-medium">Criar Nova</span>
                </a>

                <a href="minhas-presells.php" class="flex items-center gap-3 px-4 py-3 rounded-lg text-gray-400 hover:bg-gray-800 hover:text-white transition-all group">
                    <i data-lucide="list" class="w-5 h-5 group-hover:text-green-400 transition-colors"></i>
                    <span class="font-medium">Minhas Presells</span>
                </a>
            </nav>
        </aside>

        <!-- CONTEÚDO PRINCIPAL -->
        <main class="flex-1 flex flex-col min-w-0 bg-gray-900 relative">
            
            <!-- Header Simples -->
            <header class="h-20 bg-gray-900/95 backdrop-blur border-b border-gray-800 flex items-center justify-between px-8 shrink-0 z-20">
                <div class="flex items-center gap-4">
                    <a href="index.php" class="p-2 text-gray-400 hover:text-white bg-gray-800 rounded-lg transition-colors">
                        <i data-lucide="arrow-left" class="w-5 h-5"></i>
                    </a>
                    <h1 class="text-xl font-bold text-white">Criar Nova Página</h1>
                </div>
            </header>

            <!-- Area de Scroll do Form -->
            <div class="flex-1 overflow-y-auto p-8 pb-20">
                <div class="max-w-4xl mx-auto">

                    <!-- Exibição de Erros PHP -->
                    <?php if (!empty($errors)): ?>
                        <div class="bg-red-900/30 border border-red-500/50 text-red-200 p-4 rounded-xl mb-6 flex gap-3 items-start">
                            <i data-lucide="alert-circle" class="w-5 h-5 text-red-500 shrink-0 mt-0.5"></i>
                            <div>
                                <p class="font-bold text-red-400">Ops! Algo deu errado:</p>
                                <ul class="list-disc pl-5 mt-1 text-sm space-y-1">
                                    <?php foreach ($errors as $error): ?>
                                        <li><?= htmlspecialchars($error) ?></li>
                                    <?php endforeach; ?>
                                </ul>
                            </div>
                        </div>
                    <?php endif; ?>
                    
                    <!-- FORMULÁRIO -->
                    <form method="POST" class="bg-gray-800 border border-gray-700 rounded-2xl shadow-xl overflow-hidden">
                        <div class="p-8 space-y-6">
                            
                            <!-- Título -->
                            <div>
                                <label for="title" class="block text-sm font-medium text-gray-300 mb-2">Título da Página <span class="text-red-500">*</span></label>
                                <input type="text" id="title" name="title" required
                                    value="<?= htmlspecialchars($presell['title']) ?>"
                                    placeholder="Ex: Método de Emagrecimento 2024"
                                    class="w-full px-4 py-3 bg-gray-900 border border-gray-700 rounded-lg text-white placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent transition-all">
                            </div>
                            
                            <!-- Slug -->
                            <div>
                                <label for="slug" class="block text-sm font-medium text-gray-300 mb-2">Link da Página (Slug) <span class="text-red-500">*</span></label>
                                <div class="flex rounded-lg shadow-sm">
                                    <span class="inline-flex items-center px-4 rounded-l-lg border border-r-0 border-gray-700 bg-gray-900/50 text-gray-400 text-sm">
                                        <?= SITE_URL ?>/
                                    </span>
                                    <input type="text" id="slug" name="slug" 
                                        value="<?= htmlspecialchars($presell['slug']) ?>"
                                        placeholder="metodo-emagrecimento"
                                        class="flex-1 min-w-0 block w-full px-4 py-3 bg-gray-900 border border-gray-700 rounded-r-lg text-white placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent transition-all">
                                </div>
                                <p class="mt-2 text-xs text-gray-500">Deixe em branco para gerar automaticamente baseado no título.</p>
                            </div>
                            
                            <!-- Editor de Conteúdo -->
                            <div>
                                <label for="content" class="block text-sm font-medium text-gray-300 mb-2">Conteúdo da Presell <span class="text-red-500">*</span></label>
                                <div class="text-black"> <!-- Wrapper preto para o CKEditor não quebrar styles -->
                                    <textarea id="content" name="content"><?= htmlspecialchars($presell['content']) ?></textarea>
                                </div>
                            </div>
                            
                            <!-- Status -->
                            <div>
                                <label for="status" class="block text-sm font-medium text-gray-300 mb-2">Status de Publicação</label>
                                <div class="relative">
                                    <select id="status" name="status" class="w-full px-4 py-3 bg-gray-900 border border-gray-700 rounded-lg text-white appearance-none focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent cursor-pointer">
                                        <option value="draft" <?= $presell['status'] === 'draft' ? 'selected' : '' ?>>📝 Rascunho (Não visível)</option>
                                        <option value="published" <?= $presell['status'] === 'published' ? 'selected' : '' ?>>✅ Publicado (Visível)</option>
                                    </select>
                                    <i data-lucide="chevron-down" class="absolute right-4 top-3.5 w-5 h-5 text-gray-400 pointer-events-none"></i>
                                </div>
                            </div>

                        </div>
                        
                        <!-- Footer do Form -->
                        <div class="bg-gray-900/50 px-8 py-5 flex justify-end gap-3 border-t border-gray-700">
                            <a href="index.php" class="px-6 py-2.5 rounded-lg text-gray-300 hover:text-white hover:bg-gray-700 font-medium transition-colors">
                                Cancelar
                            </a>
                            <button type="submit" class="bg-green-600 hover:bg-green-500 text-white px-6 py-2.5 rounded-lg font-bold shadow-lg shadow-green-900/50 transition-all flex items-center gap-2">
                                <i data-lucide="save" class="w-4 h-4"></i>
                                Salvar Presell
                            </button>
                        </div>
                    </form>

                </div>
            </div>
        </main>
    </div>

    <script>
        // Renderiza ícones
        lucide.createIcons();

        // Scripts de Lógica
        const titleInput = document.getElementById('title');
        const slugInput = document.getElementById('slug');

        // Função de Slug (Javascript) para visualização em tempo real
        function createSlugJS(text) {
            return text.toString().toLowerCase()
                .normalize('NFD').replace(/[\u0300-\u036f]/g, '') // Remove acentos
                .replace(/\s+/g, '-')           // Espaços viram hifens
                .replace(/[^\w\-]+/g, '')       // Remove caracteres especiais
                .replace(/\-\-+/g, '-')         // Remove hifens duplicados
                .replace(/^-+/, '')             // Remove hifen do inicio
                .replace(/-+$/, '');            // Remove hifen do fim
        }

        titleInput.addEventListener('input', function() {
            if (!slugInput.value || slugInput.dataset.auto === "true") {
                slugInput.value = createSlugJS(this.value);
                slugInput.dataset.auto = "true";
            }
        });

        slugInput.addEventListener('input', function() {
            slugInput.dataset.auto = "false";
        });
        
        // Inicializar CKEditor
        ClassicEditor
            .create(document.querySelector('#content'), {
                toolbar: {
                    items: [
                        'heading', '|',
                        'bold', 'italic', 'link', 'bulletedList', 'numberedList', '|',
                        'blockQuote', 'undo', 'redo'
                    ]
                }
            })
            .catch(error => {
                console.error(error);
            });
    </script>
</body>
</html>
