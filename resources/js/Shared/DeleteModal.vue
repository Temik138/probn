<template>
    <Transition name="modal">
      <div v-if="show" class="modal-mask">
        <div class="modal-container">
          <div class="modal-header">
            <h3>Подтверждение удаления</h3>
          </div>
          
          <div class="modal-body">
            <slot>Вы уверены, что хотите удалить этот товар?</slot>
          </div>
          
          <div class="modal-footer">
            <button class="modal-button cancel" @click="$emit('cancel')">
              Отмена
            </button>
            <button class="modal-button confirm" @click="$emit('confirm')">
              Удалить
            </button>
          </div>
        </div>
      </div>
    </Transition>
  </template>
  
  <script setup>
  defineProps({
    show: Boolean
  });
  
  defineEmits(['cancel', 'confirm']);
  </script>
  
  <style scoped>
  .modal-mask {
    position: fixed;
    z-index: 9998;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0, 0, 0, 0.5);
    display: flex;
    justify-content: center;
    align-items: center;
    transition: opacity 0.3s ease;
  }
  
  .modal-container {
    width: 400px;
    max-width: 90%;
    background-color: #fff;
    border-radius: 8px;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.33);
    transition: all 0.3s ease;
    padding: 20px;
  }
  
  .modal-header h3 {
    margin-top: 0;
    color: #333;
  }
  
  .modal-body {
    margin: 20px 0;
  }
  
  .modal-footer {
    display: flex;
    justify-content: flex-end;
    gap: 10px;
  }
  
  .modal-button {
    padding: 8px 16px;
    border-radius: 4px;
    cursor: pointer;
    border: none;
  }
  
  .modal-button.cancel {
    background-color: #e0e0e0;
  }
  
  .modal-button.confirm {
    background-color: #f44336;
    color: white;
  }
  
  .modal-enter-from,
  .modal-leave-to {
    opacity: 0;
  }
  
  .modal-enter-from .modal-container,
  .modal-leave-to .modal-container {
    transform: scale(1.1);
  }
  </style>