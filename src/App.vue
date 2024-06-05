<template>
  <main class="bg-pattern flex min-h-screen select-none flex-col items-center justify-center text-white">
    <div class="container flex flex-col items-center gap-6">
      <h1 class="text-blueish text-center text-4xl font-extrabold uppercase">Squad Busters Chest Helper</h1>

      <div class="card flex w-full max-w-lg flex-col gap-6 p-6">
        <div class="text-center text-3xl font-extrabold uppercase">{{ $t('your_last_chests') }}</div>

        <div class="grid grid-cols-3 gap-3">
          <button class="btn btn-primary" @click="select('common')"><img src="/assets/chest_common.png" alt="{{ $t('common') }} Chest" class="w-16" /></button>
          <button class="btn btn-primary" @click="select('rare')"><img src="/assets/chest_rare.png" alt="{{ $t('rare') }} Chest" class="w-16" /></button>
          <button class="btn btn-primary" @click="select('epic')"><img src="/assets/chest_epic.png" alt="{{ $t('epic') }} Chest" class="w-16" /></button>
        </div>

        <!-- Selected chests and allow remove or reorder -->
        <div ref="pattern" class="cycle cycle-sm flex flex-wrap items-center justify-center gap-4">
          <div
            v-for="(chest, index) in pattern"
            :key="index"
            :class="'bg-' + chest"
            class="flex size-6 items-center justify-center rounded-full border-2 border-black hover:bg-danger"
            @click="remove(index)"
          />
        </div>
      </div>

      <!-- Message if pattern is not found or found more than once -->
      <div v-show="position === -1 && pattern.length" class="card w-full max-w-lg p-6">
        <div class="text-center text-3xl font-extrabold uppercase">{{ $t('unknown_chests') }}</div>
        <div class="text-center">{{ $t('select_at_least_3_chests') }}</div>
      </div>

      <!-- Next chests and cycle -->
      <div v-show="position !== -1" class="card w-full max-w-lg p-6">
        <div class="pb-6 text-center text-3xl font-extrabold uppercase">{{ $t('next_chests') }}</div>

        <div class="grid grid-cols-3 gap-3">
          <div class="btn btn-secondary flex flex-col items-center justify-center gap-3">
            <img src="/assets/chest_common.png" alt="{{ $t('common') }} Chest" class="w-16 pt-2" />
            <div class="flex flex-col text-center uppercase text-common">
              <div class="text-lg">{{ $t('common') }}</div>
              <div class="-mt-1 mb-1 text-xs">{{ $t('in') }}</div>
              <div class="text-4xl">{{ position === -1 ? '??' : next.indexOf('common') + 1 }}</div>
            </div>
          </div>
          <div class="btn btn-secondary flex flex-col items-center justify-center gap-3">
            <img src="/assets/chest_rare.png" alt="{{ $t('rare') }} Chest" class="w-16 pt-2" />
            <div class="flex flex-col text-center uppercase text-rare">
              <div class="text-lg">{{ $t('rare') }}</div>
              <div class="-mt-1 mb-1 text-xs">{{ $t('in') }}</div>
              <div class="text-4xl">{{ position === -1 ? '??' : next.indexOf('rare') + 1 }}</div>
            </div>
          </div>
          <div class="btn btn-secondary flex flex-col items-center justify-center gap-3">
            <img src="/assets/chest_rare.png" alt="{{ $t('epic') }} Chest" class="w-16 pt-2" />
            <div class="flex flex-col text-center uppercase text-epic">
              <div class="text-lg">{{ $t('epic') }}</div>
              <div class="-mt-1 mb-1 text-xs">{{ $t('in') }}</div>
              <div class="text-4xl">{{ position === -1 ? '??' : next.indexOf('epic') + 1 }}</div>
            </div>
          </div>
        </div>

        <div class="py-6 text-center font-bold uppercase">{{ $t('current_cycle') }}</div>

        <div class="cycle cycle-sm cycle-dashed flex flex-wrap items-center gap-4">
          <div
            v-for="(chest, index) in next"
            :key="index"
            :class="'bg-' + chest"
            class="flex size-6 items-center justify-center rounded-full border-2 border-black"
          />
        </div>

        <div class="mt-6 flex items-center gap-3">
          <button class="btn btn-sm w-full" @click="open()">{{ $t('advance_one_chest') }}</button>
          <button class="btn btn-sm btn-danger flex-none" @click="pattern = []; position = -1">{{ $t('reset') }}</button>
        </div>
      </div>
    </div>
  </main>

  <button class="btn btn-secondary btn-sm absolute right-5 top-5" @click="$refs.credits.showModal()">{{ $t('about') }}</button>

  <dialog ref="credits" class="card max-w-lg p-6 text-white backdrop:bg-black/80">
    <div class="flex flex-col gap-3">
      <p class="text-blueish mb-3 text-center text-2xl font-extrabold uppercase">Squad Busters Chest Helper v{{ version }}</p>
      <p>This tool lets you input the last chests you got and it will tell you what chests are coming next.</p>
      <p>To remember your last chests, the tool uses your browser's local storage. No data is sent to the server, and no cookies are used.</p>
      <p>This content is not affiliated with, endorsed, sponsored, or specifically approved by Supercell and Supercell is not responsible for it. For more information see <a href="https://www.supercell.com/fan-content-policy" target="_blank">Supercell’s Fan Content Policy</a>.</p>

      <p class="font-bold uppercase">©2024 <a href="https://mgk.dev" target="_blank">MGK</a>. All rights reserved.</p>

      <div class="flex flex-col gap-1">
        <a class="btn btn-sm btn-secondary" href="https://github.com/mgkprod/sb-chest-helper" target="_blank">GitHub</a>
        <button class="btn btn-sm" @click="$refs.credits.close()">{{ $t('close') }}</button>
      </div>
    </div>
  </dialog>

  <!--
    <button class="btn">Regular</button>
    <button class="btn btn-primary">Primary</button>
    <button class="btn btn-secondary">Secondary</button>
    <button class="btn btn-info">Info</button>
    <button class="btn btn-success">Success</button>
    <button class="btn btn-danger">Danger</button>
    <div class="w-8 h-8 border-2 border-black rounded-full bg-common"></div>
    <div class="w-8 h-8 border-2 border-black rounded-full bg-rare"></div>
    <div class="w-8 h-8 border-2 border-black rounded-full bg-epic"></div>
  -->
</template>

<script>
import { useSortable } from '@vueuse/integrations/useSortable'
import cycle from './cycle'

export default {
  data() {
    return {
      pattern: [],
      position: -1,
      cycle,
    }
  },

  computed: {
    next() {
      if (this.position === -1) {
        return []
      }

      // Get the next elements in the cycle (after the current position). If the position is at the end of the cycle, start from the beginning
      let next = this.cycle.concat(this.cycle)
        .slice(this.position + 1, this.position + 45)
        .map(chest => chest.rarity)

      return next
    },

    version() {
      return window.version
    },
  },

  mounted() {
    this.load()
    this.find()

    const sortable = useSortable(this.$refs.pattern, this.pattern, {
      animation: 150,
      easing: 'cubic-bezier(1, 0, 0, 1)',
      ignore: '.btn-danger',  // Ignore the remove button
      onChange: () => { this.save() },
    })

    sortable.start()
  },

  methods: {
    select(chest) {
      // Add selected chest to the pattern
      this.pattern.push(chest)
      this.find()
      this.save()
    },

    remove(index) {
      // Remove chest from the pattern
      this.pattern.splice(index, 1)
      this.find()
      this.save()
    },

    find() {
      if (this.pattern.length < 3) {
        console.log('Not enough chests selected')
        this.position = -1
        return -1
      }

      // Find the position in the cycle
      let cycleString = this.cycle.map(chest => chest.rarity).join('')
      let patternString = this.pattern.join('')

      // To make counting easier, replace 'common' with 'c', 'rare' with 'r' and 'epic' with 'e' in both strings
      cycleString = cycleString.replace(/common/g, 'c').replace(/rare/g, 'r').replace(/epic/g, 'e')
      patternString = patternString.replace(/common/g, 'c').replace(/rare/g, 'r').replace(/epic/g, 'e')

      // Add overlaping part
      cycleString += cycleString.slice(0, patternString.length - 1)

      console.log('We are looking for the pattern:', patternString + ' in the cycle:', cycleString)

      // Try to find the pattern in the cycle
      let foundAt = cycleString.indexOf(patternString)

      // 0 is a valid position, so we need to check if the pattern is not found at all
      if (foundAt === -1) {
        console.log('Pattern not found in the cycle')
        this.position = -1
        return -1
      }

      // Check if there is more than one match
      if (cycleString.indexOf(patternString, foundAt + 1) !== -1) {
        console.log('Pattern found more than once in the cycle')
        this.position = -1
        return -1
      }

      // Convert the position. If the pattern is found in the overlaping part, we need to subtract the length of the overlaping part
      foundAt = foundAt >= this.cycle.length ? foundAt - this.cycle.length : foundAt

      // Set the position
      console.log('Pattern found in the cycle at position', foundAt)
      this.position = foundAt + patternString.length - 1
    },

    open() {
      // Add the next chest to the pattern
      this.pattern.push(this.next[0])

      // If the pattern is longer than 11 chests, remove the first chest
      if (this.pattern.length > 11) {
        this.pattern.shift()
      }

      this.find()
      this.save()
    },

    load() {
      // Load state from local storage
      this.pattern = JSON.parse(localStorage.getItem('pattern')) || []
    },

    save() {
      // Save state to local storage
      localStorage.setItem('pattern', JSON.stringify(this.pattern))
    },
  },
}
</script>
