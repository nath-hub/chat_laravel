@extends('layouts.app')

@section('content')
<div class="subscription-page">
    <!-- Header -->
    <div class="subscription-header">
        <div class="container">
            <div class="text-center py-2">
                <h4 class="display-6  mb-2">Gérez votres Abonnement</h4>
                <p class="lead text-muted mall">Choisissez le plan qui vous convient</p>
            </div>
        </div>
    </div>

    <div class="container py-5">
        @if(isset($subscription) && $subscription->statut === 'active')
            <!-- Section Abonnement Actif -->
            <div class="current-subscription-section mb-5">
                <div class="row justify-content-center">
                    <div class="col-lg-10">
                        <div class="current-subscription-card">
                            <div class="card-header-custom">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <h3 class="mb-1">
                                            <i class="bi bi-star-fill text-warning me-2"></i>
                                            Abonnement {{ $subscription->type_abonnement === 'premium' ? 'Premium' : 'Gratuit' }}
                                        </h3>
                                        <p class="text-muted mb-0">
                                            Facturation {{ $subscription->mode_paiement === 'monthly' ? 'mensuelle' : 'annuelle' }}
                                        </p>
                                    </div>
                                    <span class="status-badge status-active">
                                        <i class="bi bi-check-circle-fill me-1"></i>Actif
                                    </span>
                                </div>
                            </div>
                            <div class="card-body-custom">
                                <div class="row g-4">
                                    <div class="col-md-4">
                                        <div class="info-box">
                                            <i class="bi bi-calendar-check text-primary"></i>
                                            <div class="ms-3">
                                                <small class="text-muted d-block">Date de début</small>
                                                <strong>{{ \Carbon\Carbon::parse($subscription->date_debut)->format('d/m/Y') }}</strong>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="info-box">
                                            <i class="bi bi-calendar-x text-danger"></i>
                                            <div class="ms-3">
                                                <small class="text-muted d-block">Date de fin</small>
                                                <strong>{{ \Carbon\Carbon::parse($subscription->date_fin)->format('d/m/Y') }}</strong>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="info-box">
                                            <i class="bi bi-clock-history text-info"></i>
                                            <div class="ms-3">
                                                <small class="text-muted d-block">Temps restant</small>
                                                <strong>{{ \Carbon\Carbon::parse($subscription->date_fin)->diffForHumans() }}</strong>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                @if($subscription->type_abonnement === 'premium')
                                    <div class="mt-4 pt-4 border-top">
                                        <h5 class="mb-3">Avantages Premium</h5>
                                        <div class="row g-3">
                                            <div class="col-md-6">
                                                <div class="feature-item">
                                                    <i class="bi bi-check-circle-fill text-success"></i>
                                                    <span>Messages illimités</span>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="feature-item">
                                                    <i class="bi bi-check-circle-fill text-success"></i>
                                                    <span>Support prioritaire</span>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="feature-item">
                                                    <i class="bi bi-check-circle-fill text-success"></i>
                                                    <span>Accès aux fonctionnalités avancées</span>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="feature-item">
                                                    <i class="bi bi-check-circle-fill text-success"></i>
                                                    <span>Historique de conversation illimité</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endif

                                <div class="action-buttons mt-4 pt-4 border-top">
                                    @if($subscription->type_abonnement === 'free')
                                        <a href="#pricing" class="btn btn-upgrade">
                                            <i class="bi bi-arrow-up-circle me-2"></i>Passer à Premium
                                        </a>
                                    @else
                                        <button type="button" class="btn btn-change me-2" data-bs-toggle="modal" data-bs-target="#changePlanModal">
                                            <i class="bi bi-arrow-left-right me-2"></i>Changer de plan
                                        </button>
                                    @endif
                                    <button type="button" class="btn btn-cancel" data-bs-toggle="modal" data-bs-target="#cancelModal">
                                        <i class="bi bi-x-circle me-2"></i>Annuler l'abonnement
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif

        <!-- Section Plans de Tarification -->
        <div class="pricing-section" id="pricing">
            <div class="text-center mb-5">
                <h2 class="fw-bold mb-3">
                    @if(isset($subscription) && $subscription->statut === 'active')
                        Changer de Plan
                    @else
                        Choisissez votre Plan
                    @endif
                </h2>
                <p class="text-muted">Des plans flexibles pour tous vos besoins</p>

                <!-- Toggle Mensuel/Annuel -->
                <div class="billing-toggle mt-4">
                    <span class="toggle-label" id="monthlyLabel">Mensuel</span>
                    <label class="toggle-switch">
                        <input type="checkbox" id="billingToggle">
                        <span class="toggle-slider"></span>
                    </label>
                    <span class="toggle-label" id="yearlyLabel">
                        Annuel <span class="badge bg-success ms-1">-20%</span>
                    </span>
                </div>
            </div>

            <div class="row g-4 justify-content-center">
                <!-- Plan Gratuit -->
                <div class="col-lg-4 col-md-6">
                    <div class="pricing-card">
                        <div class="pricing-header">
                            <h3 class="plan-name">Gratuit</h3>
                            <div class="plan-price">
                                <span class="price">0 €</span>
                                <span class="period">/mois</span>
                            </div>
                            <p class="plan-description">Pour commencer</p>
                        </div>
                        <div class="pricing-body">
                            <ul class="features-list">
                                <li>
                                    <i class="bi bi-check-circle-fill text-success"></i>
                                    <span>10 messages par jour</span>
                                </li>
                                <li>
                                    <i class="bi bi-check-circle-fill text-success"></i>
                                    <span>Fonctionnalités de base</span>
                                </li>
                                <li>
                                    <i class="bi bi-check-circle-fill text-success"></i>
                                    <span>Support communautaire</span>
                                </li>
                                <li class="disabled">
                                    <i class="bi bi-x-circle-fill text-muted"></i>
                                    <span>Historique limité à 7 jours</span>
                                </li>
                                <li class="disabled">
                                    <i class="bi bi-x-circle-fill text-muted"></i>
                                    <span>Pas de support prioritaire</span>
                                </li>
                            </ul>
                        </div>
                        <div class="pricing-footer">
                            @if(!isset($subscription) || $subscription->type_abonnement !== 'free')
                                <form action="{{ route('subscription.downgrade') }}" method="POST">
                                    @csrf
                                    <button type="submit" class="btn btn-outline-primary w-100">
                                        Passer au plan gratuit
                                    </button>
                                </form>
                            @else
                                <button class="btn btn-secondary w-100" disabled>Plan actuel</button>
                            @endif
                        </div>
                    </div>
                </div>






                <!-- Plan Premium Mensuel -->
                <div class="col-lg-4 col-md-6">
                    <div class="pricing-card premium-card monthly-plan">
                        <div class="popular-badge">Le plus populaire</div>
                        <div class="pricing-header">
                            <h3 class="plan-name">Premium</h3>
                            <div class="plan-price">
                                <span class="price">9,99 €</span>
                                <span class="period">/mois</span>
                            </div>
                            <p class="plan-description">Pour les utilisateurs actifs</p>
                        </div>
                        <div class="pricing-body">
                            <ul class="features-list">
                                <li>
                                    <i class="bi bi-check-circle-fill text-success"></i>
                                    <span>Messages illimités</span>
                                </li>
                                <li>
                                    <i class="bi bi-check-circle-fill text-success"></i>
                                    <span>Toutes les fonctionnalités</span>
                                </li>
                                <li>
                                    <i class="bi bi-check-circle-fill text-success"></i>
                                    <span>Support prioritaire 24/7</span>
                                </li>
                                <li>
                                    <i class="bi bi-check-circle-fill text-success"></i>
                                    <span>Historique illimité</span>
                                </li>
                                <li>
                                    <i class="bi bi-check-circle-fill text-success"></i>
                                    <span>Accès anticipé aux nouveautés</span>
                                </li>
                            </ul>
                        </div>
                        <div class="pricing-footer">
                            @if(!isset($subscription) || $subscription->type_abonnement === 'free' || $subscription->mode_paiement !== 'monthly')
                                <form action="{{ route('subscription.subscribe') }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="plan" value="premium">
                                    <input type="hidden" name="billing" value="monthly">
                                    <button type="submit" class="btn btn-primary w-100">
                                        <i class="bi bi-star-fill me-2"></i>S'abonner maintenant
                                    </button>
                                </form>
                            @else
                                <button class="btn btn-secondary w-100" disabled>Plan actuel</button>
                            @endif
                        </div>
                    </div>
                </div>





                <!-- Plan Premium Annuel -->
                <div class="col-lg-4 col-md-6">
                    <div class="pricing-card premium-card yearly-plan">
                        <div class="popular-badge">Meilleure valeur</div>
                        <div class="pricing-header">
                            <h3 class="plan-name">Premium Annuel</h3>
                            <div class="plan-price">
                                <span class="price">95,99 €</span>
                                <span class="period">/an</span>
                            </div>
                            <p class="plan-description">
                                <span class="text-decoration-line-through text-muted">119,88 €</span>
                                <span class="text-success ms-2">Économisez 24 €</span>
                            </p>
                        </div>
                        <div class="pricing-body">
                            <ul class="features-list">
                                <li>
                                    <i class="bi bi-check-circle-fill text-success"></i>
                                    <span>Messages illimités</span>
                                </li>
                                <li>
                                    <i class="bi bi-check-circle-fill text-success"></i>
                                    <span>Toutes les fonctionnalités</span>
                                </li>
                                <li>
                                    <i class="bi bi-check-circle-fill text-success"></i>
                                    <span>Support prioritaire 24/7</span>
                                </li>
                                <li>
                                    <i class="bi bi-check-circle-fill text-success"></i>
                                    <span>Historique illimité</span>
                                </li>
                                <li>
                                    <i class="bi bi-check-circle-fill text-success"></i>
                                    <span>Accès anticipé aux nouveautés</span>
                                </li>
                                <li>
                                    <i class="bi bi-check-circle-fill text-success"></i>
                                    <span><strong>2 mois gratuits</strong></span>
                                </li>
                            </ul>
                        </div>
                        <div class="pricing-footer">
                            @if(!isset($subscription) || $subscription->type_abonnement === 'free' || $subscription->mode_paiement !== 'yearly')
                                <form action="{{ route('subscription.subscribe') }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="plan" value="premium">
                                    <input type="hidden" name="billing" value="yearly">
                                    <button type="submit" class="btn btn-primary w-100">
                                        <i class="bi bi-star-fill me-2"></i>S'abonner maintenant
                                    </button>
                                </form>
                            @else
                                <button class="btn btn-secondary w-100" disabled>Plan actuel</button>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- FAQ Section -->
        <div class="faq-section mt-5 pt-5">
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <h3 class="text-center mb-4">Questions Fréquentes</h3>
                    <div class="accordion" id="faqAccordion">
                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#faq1">
                                    Puis-je annuler mon abonnement à tout moment ?
                                </button>
                            </h2>
                            <div id="faq1" class="accordion-collapse collapse show" data-bs-parent="#faqAccordion">
                                <div class="accordion-body">
                                    Oui, vous pouvez annuler votre abonnement à tout moment. Vous conserverez l'accès jusqu'à la fin de votre période de facturation.
                                </div>
                            </div>
                        </div>
                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq2">
                                    Comment passer du plan mensuel au plan annuel ?
                                </button>
                            </h2>
                            <div id="faq2" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                                <div class="accordion-body">
                                    Vous pouvez changer de plan à tout moment depuis cette page. Le crédit restant sera appliqué au nouveau plan.
                                </div>
                            </div>
                        </div>
                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq3">
                                    Quels moyens de paiement acceptez-vous ?
                                </button>
                            </h2>
                            <div id="faq3" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                                <div class="accordion-body">
                                    Nous acceptons toutes les cartes bancaires principales via Stripe (Visa, Mastercard, American Express).
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Annulation -->
<div class="modal fade" id="cancelModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header border-0">
                <h5 class="modal-title">Annuler votre abonnement</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="alert alert-warning">
                    <i class="bi bi-exclamation-triangle-fill me-2"></i>
                    <strong>Êtes-vous sûr ?</strong>
                </div>
                <p>Vous perdrez l'accès aux fonctionnalités premium à la fin de votre période de facturation.</p>
                <p class="text-muted mb-0">Date de fin : <strong>{{ isset($subscription) ? \Carbon\Carbon::parse($subscription->date_fin)->format('d/m/Y') : '' }}</strong></p>
            </div>
            <div class="modal-footer border-0">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Conserver</button>
                <form action="{{ route('subscription.cancel') }}" method="POST" class="d-inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Confirmer l'annulation</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal Changement de Plan -->
<div class="modal fade" id="changePlanModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header border-0">
                <h5 class="modal-title">Changer de plan de facturation</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p>Choisissez votre nouveau mode de facturation :</p>
                <div class="d-grid gap-3">
                    <form action="{{ route('subscription.change') }}" method="POST">
                        @csrf
                        <input type="hidden" name="billing" value="monthly">
                        <button type="submit" class="btn btn-outline-primary w-100 text-start">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <strong>Mensuel</strong>
                                    <div class="small text-muted">9,99 € / mois</div>
                                </div>
                                <i class="bi bi-arrow-right"></i>
                            </div>
                        </button>
                    </form>
                    <form action="{{ route('subscription.change') }}" method="POST">
                        @csrf
                        <input type="hidden" name="billing" value="yearly">
                        <button type="submit" class="btn btn-outline-primary w-100 text-start">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <strong>Annuel</strong>
                                    <div class="small text-muted">95,99 € / an <span class="badge bg-success">-20%</span></div>
                                </div>
                                <i class="bi bi-arrow-right"></i>
                            </div>
                        </button>
                    </form>
                </div>
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
    --warning-color: #f59e0b;
    --gradient-start: #7c3aed;
    --gradient-end: #ec4899;
}

.subscription-page {
    background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
    min-height: 100vh;
}

.subscription-header {
    background: linear-gradient(135deg, var(--gradient-start) 0%, var(--gradient-end) 100%);
    color: white;
    font-size: 10px;
}

/* Current Subscription Card */
.current-subscription-card {
    background: white;
    border-radius: 16px;
    overflow: hidden;
    box-shadow: 0 10px 40px rgba(0, 0, 0, 0.1);
}

.card-header-custom {
    background: linear-gradient(135deg, var(--gradient-start) 0%, var(--gradient-end) 100%);
    color: white;
    padding: 2rem;
}

.card-body-custom {
    padding: 2rem;
}

.status-badge {
    padding: 8px 16px;
    border-radius: 20px;
    font-size: 0.875rem;
    font-weight: 600;
    display: inline-flex;
    align-items: center;
}

.status-active {
    background-color: rgba(16, 185, 129, 0.2);
    color: #059669;
}

.info-box {
    display: flex;
    align-items: center;
    padding: 1rem;
    background-color: #f9fafb;
    border-radius: 12px;
}

.info-box i {
    font-size: 1.75rem;
}

.feature-item {
    display: flex;
    align-items: center;
    gap: 0.75rem;
    font-size: 0.938rem;
}

.feature-item i {
    font-size: 1.25rem;
}

/* Action Buttons */
.btn-upgrade {
    background: linear-gradient(135deg, var(--gradient-start) 0%, var(--gradient-end) 100%);
    color: white;
    border: none;
    padding: 12px 32px;
    border-radius: 10px;
    font-weight: 600;
    transition: all 0.3s;
}

.btn-upgrade:hover {
    transform: translateY(-2px);
    box-shadow: 0 10px 25px rgba(124, 58, 237, 0.4);
    color: white;
}

.btn-change {
    background-color: white;
    color: var(--primary-color);
    border: 2px solid var(--primary-color);
    padding: 10px 24px;
    border-radius: 10px;
    font-weight: 600;
    transition: all 0.3s;
}

.btn-change:hover {
    background-color: var(--primary-color);
    color: white;
}

.btn-cancel {
    background-color: white;
    color: var(--danger-color);
    border: 2px solid var(--danger-color);
    padding: 10px 24px;
    border-radius: 10px;
    font-weight: 600;
    transition: all 0.3s;
}

.btn-cancel:hover {
    background-color: var(--danger-color);
    color: white;
}

/* Billing Toggle */
.billing-toggle {
    display: inline-flex;
    align-items: center;
    gap: 1rem;
    background: white;
    padding: 0.5rem 1.5rem;
    border-radius: 50px;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
}

.toggle-label {
    font-weight: 600;
    color: #6b7280;
    cursor: pointer;
}

.toggle-switch {
    position: relative;
    display: inline-block;
    width: 56px;
    height: 28px;
}

.toggle-switch input {
    opacity: 0;
    width: 0;
    height: 0;
}

.toggle-slider {
    position: absolute;
    cursor: pointer;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background-color: #cbd5e1;
    transition: 0.4s;
    border-radius: 28px;
}

.toggle-slider:before {
    position: absolute;
    content: "";
    height: 22px;
    width: 22px;
    left: 3px;
    bottom: 3px;
    background-color: white;
    transition: 0.4s;
    border-radius: 50%;
}

.toggle-switch input:checked + .toggle-slider {
    background: linear-gradient(135deg, var(--gradient-start) 0%, var(--gradient-end) 100%);
}

.toggle-switch input:checked + .toggle-slider:before {
    transform: translateX(28px);
}

/* Pricing Cards */
.pricing-card {
    background: white;
    border-radius: 16px;
    padding: 2rem;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
    transition: all 0.3s;
    position: relative;
    height: 100%;
    display: flex;
    flex-direction: column;
}

.pricing-card:hover {
    transform: translateY(-8px);
    box-shadow: 0 12px 40px rgba(0, 0, 0, 0.15);
}

.premium-card {
    border: 2px solid var(--primary-color);
    box-shadow: 0 8px 30px rgba(124, 58, 237, 0.2);
}

.popular-badge {
    position: absolute;
    top: -12px;
    right: 20px;
    background: linear-gradient(135deg, var(--gradient-start) 0%, var(--gradient-end) 100%);
    color: white;
    padding: 6px 20px;
    border-radius: 20px;
    font-size: 0.813rem;
    font-weight: 700;
}

.pricing-header {
    text-align: center;
    padding-bottom: 1.5rem;
    border-bottom: 2px solid #f3f4f6;
}

.plan-name {
    font-size: 1.5rem;
    font-weight: 700;
    color: var(--primary-color);
    margin-bottom: 1rem;
}

.plan-price {
    margin: 1.5rem 0;
}

.price {
    font-size: 3rem;
    font-weight: 800;
    color: #1f2937;
}

.period {
    font-size: 1rem;
    color: #6b7280;
}

.plan-description {
    color: #6b7280;
    margin: 0;
}

.pricing-body {
    flex: 1;
    padding: 2rem 0;
}

.features-list {
    list-style: none;
    padding: 0;
    margin: 0;
}

.features-list li {
    display: flex;
    align-items: center;
    gap: 0.75rem;
    padding: 0.75rem 0;
    font-size: 0.938rem;
}

.features-list li i {
    font-size: 1.25rem;
    flex-shrink: 0;
}

.features-list li.disabled {
    color: #9ca3af;
}

.pricing-footer {
    padding-top: 1.5rem;
    border-top: 2px solid #f3f4f6;
}

/* FAQ */
.faq-section .accordion-item {
    border: none;
    margin-bottom: 1rem;
    border-radius: 12px;
    overflow: hidden;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
}

.faq-section .accordion-button {
    font-weight: 600;
    color: var(--primary-color);
    background-color: white;
    border: none;
    padding: 1.25rem 1.5rem;
}

.faq-section .accordion-button:not(.collapsed) {
    background-color: #f9fafb;
    color: var(--primary-color);
    box-shadow: none;
}

.faq-section .accordion-button:focus {
    box-shadow: none;
    border-color: transparent;
}

.faq-section .accordion-body {
    padding: 1.25rem 1.5rem;
}

/* Responsive */
@media (max-width: 768px) {
    .pricing-card {
        margin-bottom: 2rem;
    }

    .current-subscription-card .action-buttons {
        display: flex;
        flex-direction: column;
        gap: 0.75rem;
    }

    .current-subscription-card .action-buttons .btn {
        width: 100%;
    }
}
</style>

@endsection
