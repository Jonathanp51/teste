<?php
require_once '../includes/config.php';
requireLogin();

$errors = [];
$presell = [
    'title' => '',
    'slug' => '',
    'content' => '',
    'status' => 'draft'
];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Processar formulário
    $presell = array_merge($presell, $_POST);
    
    // Validação
    if (empty($presell['title'])) {
        $errors[] = 'O título é obrigatório';
    }
    
    if (empty($presell['slug'])) {
        // Gerar slug a partir do título se não for fornecido
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
            header("Location: edit.php?id=$presell_id");
            exit;
        } else {
            $errors[] = 'Erro ao salvar o presell. Tente novamente.';
        }
    }
}

include '../templates/header.php';
?>

<div class="container mx-auto px-4 py-8">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-gray-800">Criar Novo Presell</h1>
        <a href="../index.php" class="text-gray-600 hover:text-gray-800">
            <i class="fas fa-arrow-left mr-1"></i> Voltar para a lista
        </a>
    </div>
    
    <?php if (!empty($errors)): ?>
        <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6" role="alert">
            <p class="font-bold">Erro</p>
            <ul class="list-disc pl-5 mt-2">
                <?php foreach ($errors as $error): ?>
                    <li><?= htmlspecialchars($error) ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>
    
    <form method="POST" class="bg-white rounded-lg shadow overflow-hidden">
        <div class="p-6">
            <div class="mb-6">
                <label for="title" class="block text-sm font-medium text-gray-700 mb-1">Título *</label>
                <input type="text" id="title" name="title" required
                    value="<?= htmlspecialchars($presell['title']) ?>"
                    class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
            </div>
            
            <div class="mb-6">
                <label for="slug" class="block text-sm font-medium text-gray-700 mb-1">Slug (URL amigável) *</label>
                <div class="mt-1 flex rounded-md shadow-sm">
                    <span class="inline-flex items-center px-3 rounded-l-md border border-r-0 border-gray-300 bg-gray-50 text-gray-500 text-sm">
                        <?= SITE_URL ?>/
                    </span>
                    <input type="text" id="slug" name="slug" 
                        value="<?= htmlspecialchars($presell['slug']) ?>"
                        class="flex-1 min-w-0 block w-full px-3 py-2 rounded-none rounded-r-md border border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
                </div>
                <p class="mt-1 text-sm text-gray-500">Deixe em branco para gerar automaticamente do título.</p>
            </div>
            
            <div class="mb-6">
                <label for="content" class="block text-sm font-medium text-gray-700 mb-1">Conteúdo *</label>
                <textarea id="content" name="content" rows="15" required
                    class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500"><?= htmlspecialchars($presell['content']) ?></textarea>
            </div>
            
            <div class="mb-6">
                <label for="status" class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                <select id="status" name="status" class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
                    <option value="draft" <?= $presell['status'] === 'draft' ? 'selected' : '' ?>>Rascunho</option>
                    <option value="published" <?= $presell['status'] === 'published' ? 'selected' : '' ?>>Publicado</option>
                </select>
            </div>
        </div>
        
        <div class="bg-gray-50 px-6 py-3 flex justify-end">
            <button type="button" class="bg-gray-200 text-gray-800 px-4 py-2 rounded-md mr-2 hover:bg-gray-300">
                Visualizar
            </button>
            <button type="submit" class="bg-indigo-600 text-white px-4 py-2 rounded-md hover:bg-indigo-700">
                <i class="fas fa-save mr-1"></i> Salvar Presell
            </button>
        </div>
    </form>
</div>

<!-- CKEditor -->
<script src="https://cdn.ckeditor.com/ckeditor5/30.0.0/classic/ckeditor.js"></script>
<script>
    // Gerar slug a partir do título
    document.getElementById('title').addEventListener('input', function() {
        const slugInput = document.getElementById('slug');
        if (!slugInput.value) {
            slugInput.value = createSlug(this.value);
        }
    });
    
    // Inicializar editor
    ClassicEditor
        .create(document.querySelector('#content'), {
            toolbar: {
                items: [
                    'heading', '|',
                    'bold', 'italic', 'link', 'bulletedList', 'numberedList', '|',
                    'indent', 'outdent', '|',
                    'blockQuote', 'insertTable', 'undo', 'redo'
                ]
            }
        })
        .catch(error => {
            console.error(error);
        });
    
    // Função para criar slug
    function createSlug(text) {
        return text.toString().toLowerCase()
            .replace(/\s+/g, '-')           // Substitui espaços por hífens
            .replace(/[^\w\-]+/g, '')       // Remove caracteres especiais
            .replace(/\-\-+/g, '-')         // Substitui múltiplos hífens por um único
            .replace(/^-+/, '')             // Remove hífens do início
            .replace(/-+$/, '');            // Remove hífens do final
    }
</script>

<?php include '../templates/footer.php'; ?>
