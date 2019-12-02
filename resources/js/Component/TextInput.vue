<template>
  <div class="flex flex-col">
    <div class="relative flex flex-row font-title" :style="`--current-color: var(--color-${currentColor});`">
      <label
        v-if="label"
        class="absolute z-10 px-2 text-sm font-semibold rounded-full pointer-events-none bg-surface transition-all transition-250"
        :active="active"
        :class="labelClassObject"
        v-html="labelText"
      />
      <scale-transition origin="center">
        <span
          v-show="canClear"
          class="absolute z-20 px-2 text-sm font-semibold rounded-full cursor-pointer clear-button bg-surface transition-all transition-250 text-on-surface-muted hover:text-on-surface-high-emphasis"
          :style="clearableStyleObject"
          @click="clear"
        >
          <font-awesome-icon icon="times" />
        </span>
      </scale-transition>

      <template v-if="textarea">
        <textarea
          ref="input"
          v-bind="commonProperties"
          @input="onInput"
          @focus="onFocus"
          @blur="onBlur"
          :v-html="value"
          v-ripple
        />
      </template>
      <template v-else>
        <input
          ref="input"
          v-bind="commonProperties"
          @input="onInput"
          @focus="onFocus"
          @blur="onBlur"
          :placeholder="label ? '' : placeholder"
          :value="value"
          :style="resize"
          v-ripple
        />
      </template>
    </div>
    <scale-transition>
      <div v-if="hasErrors" v-html="$_(errors[0])" class="mt-2 ml-0 text-xs text-error-high-emphasis md:ml-4" />
      <div v-if="hint && !hasErrors" v-html="$_(hint)" class="mt-2 ml-0 text-xs text-on-surface-muted md:ml-4" />
    </scale-transition>
  </div>
</template>

<script>
import _ from 'lodash';
import { ScaleTransition } from 'vue2-transitions';

export default {
  inheritAttrs: false,
  components: {
    ScaleTransition,
  },
  data: () => ({
    focused: false,
  }),
  methods: {
    onInput(e) {
      this.$emit('input', e.target.value);
    },
    onFocus(e) {
      this.focused = true;
      this.$emit('focus', e);
      this.$forceUpdate();
    },
    onBlur(e) {
      this.focused = false;
      this.$emit('blur', e);
      this.$forceUpdate();
    },
    focus() {
      this.$refs.input.focus();
    },
    clear() {
      this.$emit('input', '');
    },
  },
  computed: {
    hasErrors() {
      return _.size(this.errors) > 0;
    },
    canClear() {
      return this.clearable && _.size(this.value) > 0 && !this.disabled && !this.textarea;
    },
    currentColor() {
      if (this.hasErrors) {
        return 'error';
      }
      if (!this.active) {
        return 'on-surface';
      }
      return this.color;
    },
    commonProperties() {
      return {
        class: _.filter(
          [
            'self-center text-sm pt-3 pb-2 px-4 rounded transition-all transition-250',
            this.disabled ? 'disabled' : null,
            this.inputClass,
          ],
          _.size,
        ),
        ...this.$attrs,
        disabled: this.disabled,
        required: this.required,
        active: this.active,
      };
    },
    active() {
      return this.focused || _.size(this.value) > 0 || this.hasErrors;
    },
    labelText() {
      return this.required ? `${this.label} <code>*</code>` : this.label;
    },
    labelClassObject() {
      return {
        disabled: this.disabled,
        'label-top': this.active,
        [this.labelClass || '']: true,
        [`text-on-surface-high-emphasis`]: !this.active,
        [`text-${this.currentColor}`]: this.active,
      };
    },
    clearableStyleObject() {
      return {};
    },
  },
  props: {
    value: String,
    textarea: Boolean,
    label: String,
    disabled: Boolean,
    required: Boolean,
    placeholder: String,
    labelClass: String,
    inputClass: String,
    hint: String,
    errors: {
      type: Array,
      default: () => [],
    },
    clearable: {
      type: Boolean,
      default: true,
    },
    color: {
      type: String,
      default: 'brand',
    },
    resize: {
      type: String,
      default: 'none',
      validator(value) {
        return ['none', 'both', 'vertical', 'horizontal'].includes(value);
      },
    },
  },
};
</script>

<style lang="postcss" scoped>
label {
  top: 0.775em;
  left: 0.5em;
  &[active],
  &[error] {
    @apply text-xs;
    /* @apply text-primary; */
    top: -0.75em;
    left: 0.75em;
  }
  &[disabled] {
    @apply cursor-not-allowed;
    @apply text-on-surface-disabled;
  }
}
.clear-button {
  top: 0.775em;
  right: 0.5em;
  &[disabled] {
    @apply cursor-not-allowed;
    @apply text-on-surface-disabled;
  }
}
textarea,
input {
  @apply flex-grow cursor-text;
  @apply bg-surface;
  @apply text-on-surface;
  box-shadow: 0px 0px 0px 1px rgba(var(--color-on-surface), var(--border));
  /* box-shadow: 0px 0px 0px 1px rgba(var(--color-on-surface), var(--inactive)); */
  &:hover {
    box-shadow: 0px 0px 0px 1px rgba(var(--color-on-surface), var(--border-hover));
    /* box-shadow: 0px 0px 0px 1px rgba(var(--color-on-surface), var(--high-emphasis)); */
  }
  &:focus,
  &[active],
  &[error] {
    @apply outline-none;
    @apply bg-surface;
    box-shadow: 0px 0px 0px 2px rgba(var(--current-color), var(--border-active));
  }
  &[disabled] {
    @apply cursor-not-allowed;
    @apply text-on-surface-disabled;
    box-shadow: 0px 0px 0px 1px rgba(var(--color-on-surface), var(--border-disabled));
  }
}
textarea {
  min-height: 3em;
}
</style>
