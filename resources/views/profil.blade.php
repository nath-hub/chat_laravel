@extends('layouts.app')

@section('content')
<div class="settings-page">
    <!-- Header avec élévation -->
    <div class="settings-header">
        <div class="container-fluid px-4">
            <div class="row align-items-center">
                <div class="col-md-8 d-flex align-items-center">
                    <a href="{{ route('home') }}" class="btn-back">
                        <i class="bi bi-arrow-left me-2"></i>Retour
                    </a>
                    <div class="header-title ms-5">
                        <h1 class="mb-1">Paramètres</h1>
                        <p class="mb-0">Personnalisez votre expérience de chat</p>
                    </div>
                </div>
                <div class="col-md-4 text-end">
                    <button type="button" class="btn-save" id="saveBtn">
                        <span class="save-text">Sauvegarder</span>
                        <span class="saving-text d-none">
                            <span class="spinner-border spinner-border-sm me-2"></span>Sauvegarde...
                        </span>
                        <span class="saved-text d-none">✓ Sauvegardé</span>
                    </button>
                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid px-4 py-4 settings-content">
        <!-- 1. Profil Utilisateur -->
        <div class="settings-card mb-4">
            <div class="card-body">
                <h2 class="card-title">Profil Utilisateur</h2>
                <div class="row">
                    <div class="col-md-4 text-center profile-section">
                        <!-- Avatar -->
                        <div class="avatar-container mb-3">
                            <img src="{{ $user->avatar }}"
                                 alt="Avatar"
                                 class="avatar-image"
                                 id="avatarPreview">
                        </div>
                        <button type="button" class="btn-avatar-change" onclick="document.getElementById('avatarInput').click()">
                            <i class="bi bi-camera"></i>
                        </button>
                        <input type="file" id="avatarInput" accept="image/*" class="d-none">
                        <small class="d-block mt-2 text-primary">Changer l'avatar</small>

                        <div class="mt-4">
                            <span class="status-badge active mb-2">Compte Actif</span>
                            <span class="status-badge subscribed">Abonné</span>
                        </div>
                    </div>

                    <div class="col-md-8">
                        <div class="form-group">
                            <label class="form-label">Nom d'utilisateur</label>
                            <input type="text" class="form-control-modern" value="{{ $user->username }}" id="username">
                        </div>
                        <div class="form-group">
                            <label class="form-label">Email</label>
                            <div class="input-with-icon">
                                <input type="email" class="form-control-modern" value="{{ $user->email }}" readonly>
                                <i class="bi bi-check-circle input-icon"></i>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="form-label">Biographie</label>
                            <textarea class="form-control-modern" rows="3" id="bio">{{ $user->biographie }}</textarea>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- 2. Apparence -->
        <div class="settings-card mb-4">
            <div class="card-body">
                <h2 class="card-title">Apparence</h2>
                <div class="row">
                    <div class="col-md-6">
                        <label class="form-label mb-3">Thème</label>
                        <div class="radio-group">
                            <label class="radio-option">
                                <input type="radio" name="theme" value="clair" checked>
                                <span class="radio-custom"></span>
                                <span class="radio-label">Clair</span>
                            </label>
                            <label class="radio-option">
                                <input type="radio" name="theme" value="sombre">
                                <span class="radio-custom"></span>
                                <span class="radio-label">Sombre</span>
                            </label>
                            <label class="radio-option">
                                <input type="radio" name="theme" value="auto">
                                <span class="radio-custom"></span>
                                <span class="radio-label">Auto</span>
                            </label>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Taille de police</label>
                        <div class="slider-container">
                            <input type="range" class="slider-modern" min="12" max="20" step="1" value="14" id="fontSize">
                            <div class="slider-value" id="fontSizeValue">14</div>
                        </div>
                    </div>
                </div>
                <div class="switch-group mt-4">
                    <label class="switch-modern">
                        <input type="checkbox" id="animations" checked>
                        <span class="switch-slider"></span>
                        <span class="switch-label">Activer les animations de l'interface</span>
                    </label>
                </div>
            </div>
        </div>

        <!-- 3. Préférences de Chat -->
        <div class="settings-card mb-4">
            <div class="card-body">
                <h2 class="card-title">Préférences de Chat</h2>
                <div class="switch-group">
                    <label class="switch-modern">
                        <input type="checkbox" id="enterToSend" checked>
                        <span class="switch-slider"></span>
                        <span class="switch-label">Appuyer sur Entrée pour envoyer</span>
                    </label>
                </div>
                <div class="switch-group">
                    <label class="switch-modern">
                        <input type="checkbox" id="suggestions" checked>
                        <span class="switch-slider"></span>
                        <span class="switch-label">Afficher les suggestions automatiques</span>
                    </label>
                </div>
                <div class="switch-group">
                    <label class="switch-modern">
                        <input type="checkbox" id="autoCorrect">
                        <span class="switch-slider"></span>
                        <span class="switch-label">Correction automatique du texte</span>
                    </label>
                </div>
                <div class="switch-group">
                    <label class="switch-modern">
                        <input type="checkbox" id="autoDelete">
                        <span class="switch-slider"></span>
                        <span class="switch-label">Suppression automatique des anciens messages</span>
                    </label>
                </div>
            </div>
        </div>

        <!-- 4. Sécurité -->
        <div class="settings-card mb-4">
            <div class="card-body">
                <h2 class="card-title">Sécurité</h2>
                <div class="switch-group">
                    <label class="switch-modern">
                        <input type="checkbox" id="twoFA">
                        <span class="switch-slider"></span>
                        <span class="switch-label">Activer la double authentification (2FA)</span>
                    </label>
                </div>
                <div class="security-item">
                    <div class="security-info">
                        <h6 class="mb-1">Sessions actives</h6>
                        <small class="text-muted">2 appareils connectés</small>
                    </div>
                    <button type="button" class="btn-logout" onclick="logoutAll()">Déconnecter tout</button>
                </div>
            </div>
        </div>

        <!-- 5. Avancé -->
        <div class="settings-card mb-4">
            <div class="card-body">
                <h2 class="card-title">Paramètres Avancés</h2>
                <div class="advanced-buttons">
                    <button type="button" class="btn-advanced" onclick="resetSettings()">
                        Réinitialiser tous les paramètres
                    </button>
                    <button type="button" class="btn-advanced" onclick="clearCache()">
                        Vider le cache local
                    </button>
                </div>
            </div>
        </div>

        <!-- 6. Zone dangereuse -->
        <div class="settings-card danger-card mb-4">
            <div class="card-body">
                <h2 class="card-title text-danger">Zone Dangereuse</h2>
                <button type="button" class="btn-danger-action" data-bs-toggle="modal" data-bs-target="#deleteModal">
                    Supprimer mon compte
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Modal suppression -->
<div class="modal fade" id="deleteModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content modern-modal">
            <div class="modal-header">
                <h5 class="modal-title">Confirmer la suppression</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                Cette action est <strong>irréversible</strong>. Toutes vos données seront supprimées.
            </div>
            <div class="modal-footer">
                <button type="button" class="btn-modal-cancel" data-bs-dismiss="modal">Annuler</button>
                <button type="button" class="btn-modal-danger" onclick="confirmDelete()">Supprimer</button>
            </div>
        </div>
    </div>
</div>

<style>
:root {
    --primary-color: #7c3aed;
    --primary-hover: #6d28d9;
    --success-color: #10b981;
    --danger-color: #ef4444;
    --text-primary: #1f2937;
    --text-secondary: #6b7280;
    --bg-light: #f9fafb;
    --border-color: #e5e7eb;
    --shadow-sm: 0 1px 2px 0 rgba(0, 0, 0, 0.05);
    --shadow-md: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
    --shadow-lg: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
}

.settings-page {
    min-height: 100vh;
    background-color: var(--bg-light);
}

/* Header fixe avec élévation */
.settings-header {
    background: white;
    height: 80px;
    display: flex;
    align-items: center;
    box-shadow: var(--shadow-md);
    position: sticky;
    top: 0;
    z-index: 1000;
    margin-bottom: 0;
}

.btn-back {
    color: var(--primary-color);
    text-decoration: none;
    font-weight: 500;
    transition: all 0.2s;
    background: none;
    border: none;
    padding: 8px 12px;
    text-transform: lowercase;
}

.btn-back:hover {
    color: var(--primary-hover);
}

.header-title h1 {
    font-size: 1.5rem;
    font-weight: 700;
    color: var(--primary-color);
    margin: 0;
}

.header-title p {
    font-size: 0.875rem;
    color: var(--text-secondary);
}

.btn-save {
    background-color: var(--primary-color);
    color: white;
    border: none;
    padding: 10px 24px;
    border-radius: 8px;
    font-weight: 500;
    text-transform: lowercase;
    transition: all 0.3s;
    box-shadow: var(--shadow-sm);
}

.btn-save:hover {
    background-color: var(--primary-hover);
    box-shadow: var(--shadow-md);
}

.btn-save.saved {
    background-color: var(--success-color);
}

.settings-content {
    max-width: 1200px;
    margin: 0 auto;
}

/* Cards modernes */
.settings-card {
    background: white;
    border-radius: 12px;
    box-shadow: var(--shadow-sm);
    border: 1px solid var(--border-color);
    overflow: hidden;
}

.settings-card .card-body {
    padding: 2rem;
}

.card-title {
    font-size: 1.25rem;
    font-weight: 600;
    color: var(--text-primary);
    margin-bottom: 1.5rem;
}

/* Avatar section */
.avatar-container {
    position: relative;
    display: inline-block;
}

.avatar-image {
    width: 100px;
    height: 100px;
    border-radius: 50%;
    object-fit: cover;
    border: 3px solid var(--primary-color);
}

.btn-avatar-change {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    background-color: var(--primary-color);
    color: white;
    border: none;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    transition: all 0.3s;
    box-shadow: var(--shadow-md);
}

.btn-avatar-change:hover {
    background-color: var(--primary-hover);
    transform: scale(1.1);
}

/* Status badges */
.status-badge {
    display: block;
    padding: 8px 20px;
    border-radius: 20px;
    font-size: 0.875rem;
    font-weight: 500;
    margin-bottom: 8px;
}

.status-badge.active {
    background-color: #d1fae5;
    color: #065f46;
}

.status-badge.subscribed {
    background-color: #ede9fe;
    color: #5b21b6;
}

/* Form controls modernes */
.form-group {
    margin-bottom: 1.5rem;
}

.form-label {
    display: block;
    font-size: 0.875rem;
    font-weight: 500;
    color: var(--text-primary);
    margin-bottom: 0.5rem;
}

.form-control-modern {
    width: 100%;
    padding: 12px 16px;
    border: 1px solid var(--border-color);
    border-radius: 8px;
    font-size: 0.938rem;
    transition: all 0.2s;
    background-color: white;
}

.form-control-modern:focus {
    outline: none;
    border-color: var(--primary-color);
    box-shadow: 0 0 0 3px rgba(124, 58, 237, 0.1);
}

.form-control-modern:read-only {
    background-color: #f9fafb;
}

.input-with-icon {
    position: relative;
}

.input-icon {
    position: absolute;
    right: 16px;
    top: 50%;
    transform: translateY(-50%);
    color: var(--success-color);
    font-size: 1.25rem;
}

/* Radio buttons personnalisés */
.radio-group {
    display: flex;
    flex-direction: column;
    gap: 12px;
}

.radio-option {
    display: flex;
    align-items: center;
    cursor: pointer;
    position: relative;
}

.radio-option input[type="radio"] {
    position: absolute;
    opacity: 0;
}

.radio-custom {
    width: 20px;
    height: 20px;
    border: 2px solid var(--border-color);
    border-radius: 50%;
    margin-right: 12px;
    position: relative;
    transition: all 0.2s;
}

.radio-option input[type="radio"]:checked + .radio-custom {
    border-color: var(--primary-color);
}

.radio-option input[type="radio"]:checked + .radio-custom::after {
    content: '';
    position: absolute;
    width: 10px;
    height: 10px;
    background-color: var(--primary-color);
    border-radius: 50%;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
}

.radio-label {
    font-size: 0.938rem;
    color: var(--text-primary);
}

/* Slider moderne */
.slider-container {
    position: relative;
    padding-top: 10px;
}

.slider-modern {
    width: 100%;
    height: 6px;
    border-radius: 3px;
    background: linear-gradient(to right, var(--primary-color) 0%, var(--primary-color) 25%, var(--border-color) 25%, var(--border-color) 100%);
    outline: none;
    appearance: none;
}

.slider-modern::-webkit-slider-thumb {
    appearance: none;
    width: 20px;
    height: 20px;
    border-radius: 50%;
    background: var(--primary-color);
    cursor: pointer;
    box-shadow: var(--shadow-md);
    transition: all 0.2s;
}

.slider-modern::-webkit-slider-thumb:hover {
    transform: scale(1.2);
}

.slider-modern::-moz-range-thumb {
    width: 20px;
    height: 20px;
    border-radius: 50%;
    background: var(--primary-color);
    cursor: pointer;
    border: none;
    box-shadow: var(--shadow-md);
}

.slider-value {
    position: absolute;
    top: -10px;
    right: 0;
    background-color: var(--primary-color);
    color: white;
    padding: 4px 12px;
    border-radius: 12px;
    font-size: 0.813rem;
    font-weight: 600;
}

/* Switch moderne */
.switch-group {
    margin-bottom: 1.25rem;
}

.switch-modern {
    display: flex;
    align-items: center;
    cursor: pointer;
    user-select: none;
}

.switch-modern input[type="checkbox"] {
    position: absolute;
    opacity: 0;
}

.switch-slider {
    position: relative;
    width: 48px;
    height: 24px;
    background-color: #cbd5e1;
    border-radius: 24px;
    transition: all 0.3s;
    margin-right: 12px;
    flex-shrink: 0;
}

.switch-slider::before {
    content: '';
    position: absolute;
    width: 20px;
    height: 20px;
    border-radius: 50%;
    background-color: white;
    top: 2px;
    left: 2px;
    transition: all 0.3s;
    box-shadow: var(--shadow-sm);
}

.switch-modern input[type="checkbox"]:checked + .switch-slider {
    background-color: var(--primary-color);
}

.switch-modern input[type="checkbox"]:checked + .switch-slider::before {
    transform: translateX(24px);
}

.switch-label {
    font-size: 0.938rem;
    color: var(--text-primary);
}

/* Security section */
.security-item {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 1rem;
    background-color: var(--bg-light);
    border-radius: 8px;
    margin-top: 1rem;
}

.security-info h6 {
    font-size: 0.938rem;
    font-weight: 600;
    color: var(--text-primary);
    margin-bottom: 0.25rem;
}

.btn-logout {
    background-color: white;
    color: var(--danger-color);
    border: 1px solid var(--danger-color);
    padding: 8px 20px;
    border-radius: 6px;
    font-weight: 500;
    transition: all 0.2s;
    text-transform: lowercase;
}

.btn-logout:hover {
    background-color: var(--danger-color);
    color: white;
}

/* Advanced buttons */
.advanced-buttons {
    display: flex;
    gap: 12px;
    flex-wrap: wrap;
}

.btn-advanced {
    background-color: white;
    color: var(--primary-color);
    border: 1px solid var(--primary-color);
    padding: 10px 20px;
    border-radius: 8px;
    font-weight: 500;
    transition: all 0.2s;
    text-transform: lowercase;
}

.btn-advanced:hover {
    background-color: var(--primary-color);
    color: white;
}

/* Danger zone */
.danger-card {
    border-color: #fecaca;
}

.btn-danger-action {
    background-color: var(--danger-color);
    color: white;
    border: none;
    padding: 10px 24px;
    border-radius: 8px;
    font-weight: 500;
    transition: all 0.2s;
    text-transform: lowercase;
}

.btn-danger-action:hover {
    background-color: #dc2626;
}

/* Modal moderne */
.modern-modal {
    border-radius: 12px;
    border: none;
    box-shadow: var(--shadow-lg);
}

.modern-modal .modal-header {
    border-bottom: 1px solid var(--border-color);
    padding: 1.5rem;
}

.modern-modal .modal-body {
    padding: 1.5rem;
}

.modern-modal .modal-footer {
    border-top: 1px solid var(--border-color);
    padding: 1.5rem;
}

.btn-modal-cancel {
    background-color: white;
    color: var(--text-primary);
    border: 1px solid var(--border-color);
    padding: 8px 20px;
    border-radius: 6px;
    font-weight: 500;
    transition: all 0.2s;
}

.btn-modal-cancel:hover {
    background-color: var(--bg-light);
}

.btn-modal-danger {
    background-color: var(--danger-color);
    color: white;
    border: none;
    padding: 8px 20px;
    border-radius: 6px;
    font-weight: 500;
    transition: all 0.2s;
}

.btn-modal-danger:hover {
    background-color: #dc2626;
}

/* Responsive */
@media (max-width: 768px) {
    .settings-header {
        height: auto;
        padding: 1rem 0;
    }

    .settings-header .row {
        flex-direction: column;
    }

    .settings-header .col-md-4 {
        text-align: left !important;
        margin-top: 1rem;
    }

    .header-title {
        margin-left: 0 !important;
        margin-top: 0.5rem;
    }

    .settings-card .card-body {
        padding: 1.5rem;
    }
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Avatar upload
    const avatarInput = document.getElementById('avatarInput');
    if (avatarInput) {
        avatarInput.addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    document.getElementById('avatarPreview').src = e.target.result;
                };
                reader.readAsDataURL(file);
            }
        });
    }

    // Font size slider with gradient update
    const fontSizeSlider = document.getElementById('fontSize');
    const fontSizeValue = document.getElementById('fontSizeValue');
    if (fontSizeSlider && fontSizeValue) {
        fontSizeSlider.addEventListener('input', function() {
            fontSizeValue.textContent = this.value;
            const percentage = ((this.value - this.min) / (this.max - this.min)) * 100;
            this.style.background = `linear-gradient(to right, var(--primary-color) 0%, var(--primary-color) ${percentage}%, var(--border-color) ${percentage}%, var(--border-color) 100%)`;
        });
    }

    // Theme switcher
    document.querySelectorAll('input[name="theme"]').forEach(radio => {
        radio.addEventListener('change', function() {
            const theme = this.value;
            if (theme === 'sombre') {
                document.body.classList.add('dark-theme');
            } else if (theme === 'clair') {
                document.body.classList.remove('dark-theme');
            } else {
                const prefersDark = window.matchMedia('(prefers-color-scheme: dark)').matches;
                document.body.classList.toggle('dark-theme', prefersDark);
            }
        });
    });

    // Save button with animation
    const saveBtn = document.getElementById('saveBtn');
    if (saveBtn) {
        saveBtn.addEventListener('click', function() {
            const saveText = this.querySelector('.save-text');
            const savingText = this.querySelector('.saving-text');
            const savedText = this.querySelector('.saved-text');

            saveText.classList.add('d-none');
            savingText.classList.remove('d-none');
            this.disabled = true;

            // Simulate save
            setTimeout(() => {
                savingText.classList.add('d-none');
                savedText.classList.remove('d-none');
                this.classList.add('saved');

                setTimeout(() => {
                    savedText.classList.add('d-none');
                    saveText.classList.remove('d-none');
                    this.classList.remove('saved');
                    this.disabled = false;
                }, 2000);
            }, 1000);
        });
    }
});

function resetSettings() {
    if (confirm('Voulez-vous vraiment réinitialiser tous les paramètres ?')) {
        alert('Paramètres réinitialisés !');
        location.reload();
    }
}

function clearCache() {
    alert('Cache vidé !');
}

function logoutAll() {
    if (confirm('Déconnecter tous les appareils ?')) {
        alert('Toutes les sessions ont été déconnectées !');
    }
}

function confirmDelete() {
    alert('Compte supprimé !');
    const modalEl = document.getElementById('deleteModal');
    const modal = bootstrap.Modal.getInstance(modalEl);
    if (modal) {
        modal.hide();
    }
}
</script>
@endsection
