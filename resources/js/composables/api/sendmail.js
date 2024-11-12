export const sendmailAPI = ky => {
  return {
    async sendInquiryTestMail(payload) {
      return await ky(`sendmail/inquiry_test`, {
        method: 'post',
        body: JSON.stringify(payload)
      }).json()
    }
  }
}
