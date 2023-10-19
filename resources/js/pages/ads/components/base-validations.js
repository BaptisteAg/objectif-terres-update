import {maxLength, minLength, required} from "vuelidate/lib/validators";

export default {
    formInput: {
        // selectedZones: {
        //     hasZone(zones) {
        //         return zones.length;
        //     }
        // },
        aboutProject: {
            minLength: minLength(5),
            maxLength:
                maxLength(1500),
            required
        },
        // aboutContent: {
        //     minLength: minLength(5),
        //     maxLength:
        //         maxLength(1000),
        //     required
        // },
        title: {
            required,
            minLength:
                minLength(5),
        },
        documents: {
            /**
             * Only one document file is admitted
             *
             * @param {array} documents
             * @returns {boolean}
             */
            oneDocument(documents) {
                if(this.isSupportRequest) {
                    return true;
                }
                const documentTypes = [
                    "application/msword",
                    "application/vnd.openxmlformats-officedocument.wordprocessingml.document",
                    "application/pdf",
                    "application/octet-stream"
                ];
                return documents.reduce((pdfCount, document) => {
                    return pdfCount + (documentTypes.includes(document.type));
                }, 0) <= 1;
            }
            ,
            notCurrentlyUploading() {
                return !this.uploading;
            }
        }
    }
}
