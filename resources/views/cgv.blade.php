@extends('layouts.app')

@section('title', 'Conditions Générales de Vente')

@push('styles')
    <style>
        main {
            max-width: 850px;
            margin: 2rem auto;
            padding: 1rem 2rem;
            /* border-radius: 6px;  <-- retiré */
        }

        h1 {
            font-weight: 700;
            font-size: 2.2rem;
            margin-bottom: 1.5rem;
            color: #eee;
            text-align: center;
        }

        h2 {
            font-weight: 600;
            font-size: 1.5rem;
            margin-top: 2rem;
            margin-bottom: 1rem;
            color: #ddd;
            padding-left: 0.75rem;
        }

        p {
            font-size: 1.05rem;
            line-height: 1.65;
            color: #ccc;
            margin-bottom: 1.2rem;
            text-align: justify;
        }

        a {
            text-decoration: underline;
        }

        a:hover {
            text-decoration: none;
        }
    </style>
@endpush



@section('content')
    <h1>Conditions Générales de Vente (CGV)</h1>

    <p>Bienvenue sur le site Ozæna. Les présentes conditions générales de vente régissent les relations contractuelles entre
        Ozæna et ses clients dans le cadre de la vente en ligne des produits proposés sur ce site.</p>

    <h2>1. Objet</h2>
    <p>Les présentes conditions définissent les droits et obligations des parties dans le cadre de la vente de produits sur
        le site Ozæna.</p>

    <h2>2. Produits</h2>
    <p>Les produits proposés sont ceux décrits sur le site au jour de la consultation. Ozæna s'efforce d'assurer
        l'exactitude et la mise à jour des informations diffusées.</p>

    <h2>3. Prix</h2>
    <p>Les prix sont indiqués en euros, toutes taxes comprises (TTC), hors frais de livraison, qui seront précisés avant la
        validation de la commande.</p>

    <h2>4. Commande</h2>
    <p>La validation de la commande par le client vaut acceptation des présentes conditions générales de vente, sans
        réserve.</p>

    <h2>5. Paiement</h2>
    <p>Le paiement s’effectue en ligne via un système sécurisé (ex: Stripe). Le débit est effectué au moment de la
        confirmation de la commande.</p>

    <h2>6. Livraison</h2>
    <p>Les produits sont livrés à l'adresse indiquée par le client lors de la commande. Les délais de livraison sont
        indicatifs et peuvent varier.</p>

    <h2>7. Droit de rétractation</h2>
    <p>Conformément à l’article L221-18 du Code de la consommation, le client dispose d’un délai de 14 jours à compter de la
        réception du produit pour exercer son droit de rétractation sans avoir à justifier de motifs ni à payer de
        pénalités, à l’exception des frais de retour.</p>
    <p>Pour exercer ce droit, le client doit notifier sa décision par écrit (email ou courrier) à Ozæna, puis renvoyer le
        produit dans son état d'origine et complet.</p>

    <h2>8. Garantie</h2>
    <p>Les produits bénéficient de la garantie légale de conformité et des vices cachés conformément aux articles L217-4 et
        suivants du Code de la consommation.</p>

    <h2>9. Responsabilité</h2>
    <p>Ozæna ne saurait être tenue responsable des dommages résultant d’une mauvaise utilisation des produits vendus.</p>

    <h2>10. Données personnelles</h2>
    <p>Les informations recueillies sont nécessaires au traitement des commandes. Elles sont destinées à Ozæna et ne seront
        pas transmises à des tiers.</p>

    <h2>11. Loi applicable</h2>
    <p>Les présentes conditions sont soumises à la loi française. En cas de litige, une solution amiable sera recherchée
        avant toute action judiciaire.</p>

    <p>Pour toute question, contactez-nous à <a href="mailto:contact@ozæna.com">contact@ozæna.com</a>.</p>
@endsection