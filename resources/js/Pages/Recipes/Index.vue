<template>
  <div class="page-wrapper">
    <!-- Header Hero -->
    <header class="hero-header">
      <div class="hero-bg-orbs">
        <div class="orb orb-1"></div>
        <div class="orb orb-2"></div>
        <div class="orb orb-3"></div>
      </div>
      <div class="hero-content">
        <div class="hero-icon">👨‍🍳</div>
        <h1 class="hero-title">Mi Recetario Digital</h1>
        <p class="hero-subtitle">Administra tus creaciones culinarias con estilo</p>
        <div class="hero-stats">
          <div class="stat-pill">
            <span class="stat-number">{{ recipes.length }}</span>
            <span class="stat-label">Recetas</span>
          </div>
          <div class="stat-pill">
            <span class="stat-number">{{ tipos.length }}</span>
            <span class="stat-label">Categorías</span>
          </div>
        </div>
      </div>
    </header>

    <div class="main-content">
      <!-- Filtros -->
      <div class="filters-bar">
        <div class="filter-group">
          <span class="filter-icon">🔍</span>
          <input
            v-model="search"
            type="text"
            placeholder="Buscar receta..."
            class="filter-input"
          >
        </div>

        <div class="filter-group">
          <span class="filter-icon">🏷️</span>
          <select v-model="typeFilter" class="filter-input">
            <option value="">Todos los tipos</option>
            <option v-for="tipo in tipos" :key="tipo.id" :value="tipo.id">
              {{ tipo.nombre_tiporeceta }}
            </option>
          </select>
        </div>

        <div class="filter-group">
          <span class="filter-icon">⚡</span>
          <select v-model="difficultyFilter" class="filter-input">
            <option value="">Toda dificultad</option>
            <option value="fácil">🟢 Fácil</option>
            <option value="media">🟡 Media</option>
            <option value="difícil">🔴 Difícil</option>
          </select>
        </div>

        <div class="filter-group">
          <span class="filter-icon">📅</span>
          <input v-model="dateFilter" type="date" class="filter-input">
        </div>

        <button @click="openCreateModal" class="btn-add">
          <span class="btn-add-icon">+</span>
          Nueva Receta
        </button>
      </div>

      <!-- Cuadrícula de Recetas -->
      <div v-if="recipes.length > 0" class="recipe-grid">
        <div
          v-for="(recipe, index) in recipes"
          :key="recipe.id"
          class="recipe-card"
          :style="{ '--delay': index * 0.07 + 's' }"
        >
          <div class="card-accent" :style="{ background: recipe.tiporeceta?.color_hex || '#ff5733' }"></div>

          <div class="card-body">
            <span class="type-badge" :style="{ backgroundColor: (recipe.tiporeceta?.color_hex || '#ff5733') + '25', color: recipe.tiporeceta?.color_hex || '#ff5733', borderColor: (recipe.tiporeceta?.color_hex || '#ff5733') + '50' }">
              {{ recipe.tiporeceta?.nombre_tiporeceta || 'Sin tipo' }}
            </span>

            <h3 class="card-title">{{ recipe.nombre_recetas }}</h3>

            <p class="card-email">
              <span class="email-icon">✉️</span>
              {{ recipe.email }}
            </p>

            <div class="card-footer">
              <div class="difficulty-badge" :class="'diff-' + recipe.dificultad?.replace('á','a').replace('í','i')">
                <span class="diff-dot"></span>
                {{ recipe.dificultad }}
              </div>

              <div class="card-actions">
                <button @click="openEditModal(recipe)" class="btn-icon btn-edit" title="Editar">
                  ✏️
                </button>
                <button @click="confirmDelete(recipe.id)" class="btn-icon btn-delete" title="Eliminar">
                  🗑️
                </button>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- Estado vacío -->
      <div v-else class="empty-state">
        <div class="empty-icon">🍽️</div>
        <h3>No hay recetas aquí</h3>
        <p>Cambia los filtros o crea tu primera receta</p>
        <button @click="openCreateModal" class="btn-add">+ Crear nueva receta</button>
      </div>
    </div>

    <!-- Modal -->
    <Transition name="modal">
      <div v-if="showModal" class="modal-overlay" @click.self="showModal = false">
        <div class="modal-card">
          <div class="modal-header">
            <h2 class="modal-title">{{ isEdit ? '✏️ Editar Receta' : '🍳 Nueva Receta' }}</h2>
            <button class="modal-close" @click="showModal = false">✕</button>
          </div>

          <form @submit.prevent="submitForm" class="modal-form">
            <div class="form-field">
              <label>Nombre de la Receta</label>
              <input v-model="form.nombre_recetas" type="text" required placeholder="Ej: Pasta Carbonara...">
            </div>

            <div class="form-field">
              <label>Email de contacto</label>
              <input v-model="form.email" type="email" required placeholder="chef@ejemplo.com">
            </div>

            <div class="form-field">
              <label>Tipo de Receta</label>
              <select v-model="form.id_tiporeceta" required>
                <option value="" disabled>Selecciona un tipo...</option>
                <option v-for="tipo in tipos" :key="tipo.id" :value="tipo.id">
                  {{ tipo.nombre_tiporeceta }}
                </option>
              </select>
            </div>

            <div class="form-field">
              <label>Dificultad</label>
              <div class="difficulty-radio-group">
                <label class="radio-option" :class="{ active: form.dificultad === 'fácil' }">
                  <input type="radio" v-model="form.dificultad" value="fácil" hidden>
                  <span class="radio-dot green"></span> Fácil
                </label>
                <label class="radio-option" :class="{ active: form.dificultad === 'media' }">
                  <input type="radio" v-model="form.dificultad" value="media" hidden>
                  <span class="radio-dot yellow"></span> Media
                </label>
                <label class="radio-option" :class="{ active: form.dificultad === 'difícil' }">
                  <input type="radio" v-model="form.dificultad" value="difícil" hidden>
                  <span class="radio-dot red"></span> Difícil
                </label>
              </div>
            </div>

            <div class="modal-actions">
              <button type="button" @click="showModal = false" class="btn-cancel">Cancelar</button>
              <button type="submit" class="btn-submit" :disabled="form.processing">
                {{ form.processing ? 'Guardando...' : (isEdit ? 'Actualizar' : 'Crear Receta') }}
              </button>
            </div>
          </form>
        </div>
      </div>
    </Transition>
  </div>
</template>

<script setup>
import { ref, watch } from 'vue';
import { router, useForm } from '@inertiajs/vue3';
import debounce from 'lodash/debounce';

const props = defineProps({
  recipes: Array,
  tipos: Array,
  filters: Object,
});

const search = ref(props.filters?.nombre || '');
const typeFilter = ref(props.filters?.id_tiporeceta || '');
const difficultyFilter = ref(props.filters?.dificultad || '');
const dateFilter = ref(props.filters?.fecha || '');

watch([search, typeFilter, difficultyFilter, dateFilter], debounce(() => {
  router.get('/recetas', {
    nombre: search.value,
    id_tiporeceta: typeFilter.value,
    dificultad: difficultyFilter.value,
    fecha: dateFilter.value
  }, { preserveState: true, replace: true });
}, 300));

const showModal = ref(false);
const isEdit = ref(false);
const selectedId = ref(null);

const form = useForm({
  nombre_recetas: '',
  email: '',
  id_tiporeceta: '',
  dificultad: 'media',
});

const openCreateModal = () => {
  isEdit.value = false;
  form.reset();
  showModal.value = true;
};

const openEditModal = (recipe) => {
  isEdit.value = true;
  selectedId.value = recipe.id;
  form.nombre_recetas = recipe.nombre_recetas;
  form.email = recipe.email;
  form.id_tiporeceta = recipe.id_tiporeceta;
  form.dificultad = recipe.dificultad;
  showModal.value = true;
};

const submitForm = () => {
  if (isEdit.value) {
    form.put(`/recetas/${selectedId.value}`, {
      onSuccess: () => showModal.value = false,
    });
  } else {
    form.post('/recetas', {
      onSuccess: () => showModal.value = false,
    });
  }
};

const confirmDelete = (id) => {
  if (confirm('¿Seguro que quieres eliminar esta receta?')) {
    if (confirm('⚠️ Esta acción es permanente. ¿Confirmas?')) {
      router.delete(`/recetas/${id}`);
    }
  }
};
</script>

<style scoped>
/* ===== WRAPPER ===== */
.page-wrapper {
  min-height: 100vh;
  background: #0f0f13;
  font-family: 'Inter', sans-serif;
  color: #e2e8f0;
}

/* ===== HERO HEADER ===== */
.hero-header {
  position: relative;
  overflow: hidden;
  padding: 60px 20px 80px;
  text-align: center;
}

.hero-bg-orbs {
  position: absolute;
  inset: 0;
  pointer-events: none;
}

.orb {
  position: absolute;
  border-radius: 50%;
  filter: blur(80px);
  opacity: 0.35;
}

.orb-1 {
  width: 400px; height: 400px;
  background: #ff5733;
  top: -100px; left: -100px;
  animation: drift 8s ease-in-out infinite;
}

.orb-2 {
  width: 300px; height: 300px;
  background: #7c3aed;
  top: -50px; right: 10%;
  animation: drift 11s ease-in-out infinite reverse;
}

.orb-3 {
  width: 250px; height: 250px;
  background: #f59e0b;
  bottom: -50px; left: 40%;
  animation: drift 9s ease-in-out infinite 2s;
}

@keyframes drift {
  0%, 100% { transform: translate(0, 0) scale(1); }
  33% { transform: translate(30px, -20px) scale(1.05); }
  66% { transform: translate(-20px, 15px) scale(0.97); }
}

.hero-content {
  position: relative;
  z-index: 1;
}

.hero-icon {
  font-size: 4rem;
  display: block;
  margin-bottom: 16px;
  animation: float 3s ease-in-out infinite;
}

@keyframes float {
  0%, 100% { transform: translateY(0); }
  50% { transform: translateY(-10px); }
}

.hero-title {
  font-size: clamp(2rem, 5vw, 3.5rem);
  font-weight: 800;
  background: linear-gradient(135deg, #ff5733, #ff8c00, #ffd700);
  -webkit-background-clip: text;
  -webkit-text-fill-color: transparent;
  background-clip: text;
  margin-bottom: 10px;
}

.hero-subtitle {
  font-size: 1.1rem;
  color: #94a3b8;
  margin-bottom: 30px;
}

.hero-stats {
  display: flex;
  justify-content: center;
  gap: 16px;
}

.stat-pill {
  background: rgba(255,255,255,0.07);
  border: 1px solid rgba(255,255,255,0.1);
  border-radius: 50px;
  padding: 8px 20px;
  display: flex;
  align-items: center;
  gap: 8px;
  backdrop-filter: blur(10px);
}

.stat-number {
  font-size: 1.3rem;
  font-weight: 700;
  color: #ff5733;
}

.stat-label {
  font-size: 0.85rem;
  color: #94a3b8;
}

/* ===== MAIN CONTENT ===== */
.main-content {
  max-width: 1300px;
  margin: 0 auto;
  padding: 0 24px 60px;
}

/* ===== FILTERS BAR ===== */
.filters-bar {
  background: rgba(255,255,255,0.04);
  border: 1px solid rgba(255,255,255,0.08);
  border-radius: 20px;
  padding: 20px 24px;
  display: flex;
  flex-wrap: wrap;
  gap: 14px;
  align-items: center;
  margin-bottom: 36px;
  backdrop-filter: blur(20px);
}

.filter-group {
  display: flex;
  align-items: center;
  gap: 8px;
  background: rgba(255,255,255,0.05);
  border: 1px solid rgba(255,255,255,0.1);
  border-radius: 12px;
  padding: 0 14px;
  flex: 1;
  min-width: 180px;
  transition: border-color 0.2s;
}

.filter-group:focus-within {
  border-color: #ff5733;
}

.filter-icon {
  font-size: 1rem;
  flex-shrink: 0;
}

.filter-input {
  background: transparent;
  border: none;
  outline: none;
  color: #e2e8f0;
  padding: 12px 0;
  width: 100%;
  font-size: 0.9rem;
}

.filter-input::placeholder { color: #64748b; }

.filter-input option {
  background: #1e1e2a;
  color: #e2e8f0;
}

.btn-add {
  background: linear-gradient(135deg, #ff5733, #ff8c00);
  border: none;
  color: white;
  padding: 12px 24px;
  border-radius: 12px;
  font-size: 0.95rem;
  font-weight: 700;
  cursor: pointer;
  display: flex;
  align-items: center;
  gap: 8px;
  white-space: nowrap;
  transition: transform 0.2s, box-shadow 0.2s;
  box-shadow: 0 4px 20px rgba(255, 87, 51, 0.35);
}

.btn-add:hover {
  transform: translateY(-2px);
  box-shadow: 0 8px 30px rgba(255, 87, 51, 0.5);
}

.btn-add-icon {
  font-size: 1.3rem;
  font-weight: 300;
  line-height: 1;
}

/* ===== RECIPE GRID ===== */
.recipe-grid {
  display: grid;
  grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
  gap: 24px;
}

/* ===== RECIPE CARD ===== */
.recipe-card {
  background: rgba(255,255,255,0.04);
  border: 1px solid rgba(255,255,255,0.08);
  border-radius: 20px;
  overflow: hidden;
  transition: transform 0.3s ease, box-shadow 0.3s ease, border-color 0.3s ease;
  animation: fadeInUp 0.5s ease both;
  animation-delay: var(--delay, 0s);
}

@keyframes fadeInUp {
  from { opacity: 0; transform: translateY(25px); }
  to { opacity: 1; transform: translateY(0); }
}

.recipe-card:hover {
  transform: translateY(-6px);
  box-shadow: 0 20px 60px rgba(0,0,0,0.4);
  border-color: rgba(255,255,255,0.15);
}

.card-accent {
  height: 5px;
  width: 100%;
}

.card-body {
  padding: 22px;
}

.type-badge {
  display: inline-flex;
  align-items: center;
  padding: 4px 14px;
  border-radius: 50px;
  font-size: 0.75rem;
  font-weight: 700;
  letter-spacing: 0.04em;
  text-transform: uppercase;
  border: 1px solid;
  margin-bottom: 16px;
}

.card-title {
  font-size: 1.25rem;
  font-weight: 700;
  color: #f1f5f9;
  margin-bottom: 10px;
  line-height: 1.3;
}

.card-email {
  font-size: 0.82rem;
  color: #64748b;
  display: flex;
  align-items: center;
  gap: 6px;
  margin-bottom: 18px;
}

.card-footer {
  display: flex;
  align-items: center;
  justify-content: space-between;
  border-top: 1px solid rgba(255,255,255,0.06);
  padding-top: 16px;
}

.difficulty-badge {
  display: flex;
  align-items: center;
  gap: 7px;
  font-size: 0.85rem;
  font-weight: 600;
  text-transform: capitalize;
}

.diff-dot {
  width: 8px;
  height: 8px;
  border-radius: 50%;
  flex-shrink: 0;
}

.diff-facil .diff-dot, .diff-fácil .diff-dot { background: #22c55e; }
.diff-facil { color: #22c55e; }
.diff-media .diff-dot { background: #eab308; }
.diff-media { color: #eab308; }
.diff-dificil .diff-dot, .diff-difícil .diff-dot { background: #ef4444; }
.diff-dificil { color: #ef4444; }

.card-actions {
  display: flex;
  gap: 8px;
}

.btn-icon {
  background: rgba(255,255,255,0.05);
  border: 1px solid rgba(255,255,255,0.08);
  border-radius: 10px;
  width: 36px;
  height: 36px;
  display: flex;
  align-items: center;
  justify-content: center;
  cursor: pointer;
  font-size: 1rem;
  transition: background 0.2s, transform 0.2s;
}

.btn-icon:hover {
  transform: scale(1.1);
}

.btn-edit:hover { background: rgba(59, 130, 246, 0.2); border-color: rgba(59,130,246,0.4); }
.btn-delete:hover { background: rgba(239, 68, 68, 0.2); border-color: rgba(239,68,68,0.4); }

/* ===== EMPTY STATE ===== */
.empty-state {
  text-align: center;
  padding: 80px 20px;
  color: #64748b;
}

.empty-icon {
  font-size: 4rem;
  margin-bottom: 16px;
}

.empty-state h3 {
  font-size: 1.5rem;
  color: #94a3b8;
  margin-bottom: 8px;
}

.empty-state p {
  margin-bottom: 24px;
}

/* ===== MODAL ===== */
.modal-overlay {
  position: fixed;
  inset: 0;
  background: rgba(0,0,0,0.7);
  display: flex;
  align-items: center;
  justify-content: center;
  z-index: 100;
  backdrop-filter: blur(6px);
  padding: 20px;
}

.modal-card {
  background: #17171f;
  border: 1px solid rgba(255,255,255,0.1);
  border-radius: 24px;
  width: 100%;
  max-width: 520px;
  overflow: hidden;
  box-shadow: 0 30px 80px rgba(0,0,0,0.6);
}

.modal-header {
  display: flex;
  align-items: center;
  justify-content: space-between;
  padding: 24px 28px 20px;
  border-bottom: 1px solid rgba(255,255,255,0.07);
}

.modal-title {
  font-size: 1.2rem;
  font-weight: 700;
  color: #f1f5f9;
}

.modal-close {
  background: rgba(255,255,255,0.06);
  border: none;
  color: #94a3b8;
  width: 32px;
  height: 32px;
  border-radius: 8px;
  cursor: pointer;
  font-size: 0.9rem;
  transition: background 0.2s;
}

.modal-close:hover { background: rgba(239,68,68,0.2); color: #ef4444; }

.modal-form {
  padding: 24px 28px;
  display: flex;
  flex-direction: column;
  gap: 18px;
}

.form-field label {
  display: block;
  font-size: 0.8rem;
  font-weight: 600;
  color: #94a3b8;
  text-transform: uppercase;
  letter-spacing: 0.07em;
  margin-bottom: 8px;
}

.form-field input,
.form-field select {
  width: 100%;
  background: rgba(255,255,255,0.05);
  border: 1px solid rgba(255,255,255,0.1);
  border-radius: 12px;
  padding: 12px 16px;
  color: #e2e8f0;
  font-size: 0.95rem;
  outline: none;
  transition: border-color 0.2s;
  box-sizing: border-box;
}

.form-field input:focus,
.form-field select:focus {
  border-color: #ff5733;
}

.form-field select option { background: #1e1e2a; }

/* Difficulty radio */
.difficulty-radio-group {
  display: flex;
  gap: 10px;
}

.radio-option {
  flex: 1;
  display: flex;
  align-items: center;
  justify-content: center;
  gap: 8px;
  padding: 10px;
  border-radius: 12px;
  border: 1px solid rgba(255,255,255,0.1);
  cursor: pointer;
  font-size: 0.9rem;
  font-weight: 600;
  color: #64748b;
  transition: all 0.2s;
}

.radio-option.active {
  background: rgba(255,255,255,0.08);
  border-color: rgba(255,255,255,0.25);
  color: #e2e8f0;
}

.radio-dot {
  width: 10px; height: 10px;
  border-radius: 50%;
  flex-shrink: 0;
}

.radio-dot.green { background: #22c55e; }
.radio-dot.yellow { background: #eab308; }
.radio-dot.red { background: #ef4444; }

.modal-actions {
  display: flex;
  gap: 12px;
  margin-top: 6px;
}

.btn-cancel {
  flex: 1;
  padding: 12px;
  border-radius: 12px;
  background: rgba(255,255,255,0.05);
  border: 1px solid rgba(255,255,255,0.08);
  color: #94a3b8;
  cursor: pointer;
  font-weight: 600;
  transition: background 0.2s;
}

.btn-cancel:hover { background: rgba(255,255,255,0.1); }

.btn-submit {
  flex: 2;
  padding: 12px;
  border-radius: 12px;
  background: linear-gradient(135deg, #ff5733, #ff8c00);
  border: none;
  color: white;
  font-weight: 700;
  cursor: pointer;
  transition: opacity 0.2s, transform 0.2s;
  box-shadow: 0 4px 20px rgba(255, 87, 51, 0.35);
}

.btn-submit:hover:not(:disabled) {
  opacity: 0.9;
  transform: translateY(-1px);
}

.btn-submit:disabled { opacity: 0.6; cursor: not-allowed; }

/* Modal transition */
.modal-enter-active, .modal-leave-active { transition: opacity 0.25s ease; }
.modal-enter-active .modal-card, .modal-leave-active .modal-card { transition: transform 0.25s ease; }
.modal-enter-from, .modal-leave-to { opacity: 0; }
.modal-enter-from .modal-card, .modal-leave-to .modal-card { transform: scale(0.95) translateY(20px); }
</style>
