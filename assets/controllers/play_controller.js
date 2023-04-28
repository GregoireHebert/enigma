import { Controller } from '@hotwired/stimulus';

export default class extends Controller {
   static targets = ['song'];

    play() {
        fetch(`/play/${this.songTarget.value}`);
    }
}
