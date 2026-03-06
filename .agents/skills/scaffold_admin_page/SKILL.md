---
name: scaffold_admin_page
description: Tworzy zupełnie nową podstronę w Panelu Administracyjnym (Routing, Controller, Inertia Vue View).
---

# Procedura: Tworzenie nowej strony w Panelu Admina

Ten skill wdraża schemat dodawania nowych "zakładek" do panelu administracyjnego opartego o Laravel 12 + Inertia.js + Vue 3.

## Krok 1: Utworzenie nowej trasy (Route)
1. Otwórz `routes/web.php`.
2. Odnajdź grupę odpowiedzialną za Panel Administracyjny (najprawdopodobniej podpiętą pod middleware autoryzacji).
3. Wygeneruj nową rutę GET, np. `Route::get('/admin/my-new-page', [MyNewPageController::class, 'index'])->name('admin.my-new-page');`

## Krok 2: Stworzenie Kontrolera
1. Wykorzystaj Artisan do wygenerowania, lub utwórz manualnie plik `app/Http/Controllers/Admin/MyNewPageController.php`.
2. Dodaj metodę `index()`, która zwróci widok Inerti: `return Inertia::render('Admin/MyNewPage/Index', ['data' => ...]);`

## Krok 3: Utworzenie widoku Vue
1. Stwórz plik `resources/js/Pages/Admin/MyNewPage/Index.vue`.
2. Zaimportuj główny układ Panelu Admina: `import AdminLayout from '@/Layouts/AdminLayout.vue';`.
3. Owiń główny kod strony w tag `<AdminLayout>`.
4. Użyj klas Tailwind CSS v4 oraz DaisyUI do zbudowania początkowego układu (widoczny nagłówek "My New Page"). Powstrzymuj się od dodawania zbędnej wymyślonej logiki przed konsultacją.

## Krok 4: Integracja z paskiem nawigacji (Sidebar)
1. Znajdź plik odpowiadający za układ paska bocznego: poszukaj w nawigacji obecnej w `AdminLayout.vue` lub dedykowanym komponencie `AdminSidebar.vue`.
2. Dodaj link wygenerowany przez pakiet Ziggy, używając: `<Link :href="route('admin.my-new-page')">` wraz z wybraną ładną ikonką z używanego setu (PhosphorIcons / FontAwesome).

## Krok 5: Informacja zwrotna
1. Poproś użytkownika o sprawdzenie w przeglądarce czy nawigacja do nowej strony funkcjonuje jak należy przed wykonywaniem jakichkolwiek commitów.
